<?php
/**
 * Contains the Nominet class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp;

use SclRequestResponse\AbstractRequestResponse;

use SclNominetEpp\Exception\LoginRequiredException;
use SclNominetEpp\Request;
use SclNominetEpp\Request\Update;

/**
 * This class exposes all the actions of the Nominet EPP system in a nice PHP
 * class.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Nominet extends AbstractRequestResponse
{
    const LIST_MONTH  = 1;
    const LIST_EXPIRY = 2;

    // A client MUST NOT alter status values set by the server.
    // A server MAY alter or override status values set by a client, subject to local server policies.
    // Status values that can be added or removed by a client are prefixed with "client".
    const STATUS_CLIENT_DELETE_PROHIBITED   = 'clientDeleteProhibited';
    const STATUS_CLIENT_HOLD                = 'clientHold';
    const STATUS_CLIENT_RENEW               = 'clientRenewProhibited';
    const STATUS_CLIENT_TRANSFER_PROHIBITED = 'clientTransferProhibited';
    const STATUS_CLIENT_UPDATE_PROHIBITED   = 'clientUpdateProhibited';
    
    // Corresponding status values that can be added or removed by a server are prefixed with "server".
    const STATUS_SERVER_DELETE_PROHIBITED   = 'serverDeleteProhibited';
    const STATUS_SERVER_HOLD                = 'serverHold';
    const STATUS_SERVER_RENEW               = 'serverRenewProhibited';
    const STATUS_SERVER_TRANSFER_PROHIBITED = 'serverTransferProhibited';
    const STATUS_SERVER_UPDATE_PROHIBITED   = 'serverUpdateProhibited';

    //pending[action]" status MUST NOT be combined
    //with either:-
    //"client[action]Prohibited" or
    //"server[action]Prohibited" status or
    //other "pending[action]" status.
    const STATUS_PENDING_CREATE   = 'pendingCreate';
    const STATUS_PENDING_DELETE   = 'pendingDelete';
    const STATUS_PENDING_RENEW    = 'pendingRenew';
    const STATUS_PENDING_TRANSFER = 'pendingTransfer';
    const STATUS_PENDING_UPDATE   = 'pendingUpdate';
    
    const STATUS_INACTIVE = 'inactive';
    
    //"ok" status MUST NOT be combined with any other status.
    const STATUS_OKAY = 'ok';
    
    /**
     * Flag that states whether we are logged into Nominet or not.
     *
     * @var boolean
     */
    private $loggedIn = false;

    /**
     * Disconnect cleanly if we are still logged in.
     */
    public function __destruct()
    {
        if ($this->loggedIn) {
            $this->logout();
        }
    }

    /**
     * Check if we are logged into Nominet.
     *
     * @throws LoginRequiredException
     */
    private function loginCheck()
    {
        if (!$this->loggedIn) {
            throw new LoginRequiredException('Not logged into the Nominet EPP.');
        }
    }

    /**
     * The <login> command is used to establish and authenticate a session with
     * the EPP server. The <login> command must be sent to the server before any
     * other EPP command and identifies and authenticates the tag to be used
     * by the session. An EPP session is terminated by a logout command.
     *
     * @param  string  $tag
     * @param  string  $password
     * @param  string  $newPassword If specified with change the password.
     * @return boolean True if the login was successful.
     */
    public function login($tag, $password, $newPassword = null)
    {
        $request = new Request\Login();
        $request->setCredentials($tag, $password)
            ->changePassword($newPassword);

        $response = $this->processRequest($request);

        if (!$response->success()) {
            return false;
        }
        $this->loggedIn = true;

        return true;
    }

    /**
     * The <hello> command is used to obtain a greeting element from our server
     * and may be used to keep your connection with our EPP server open.
     * Sending an EPP <hello> command every 59 minutes will keep your connection
     * with our EPP server open.
     */
    public function hello()
    {
        $this->loginCheck();

        $request = new Request('hello');

        $response = $this->processRequest($request);

        // TODO Do something with the response
    }

    /**
     * A <logout> command is used to end a session with an EPP server. On receipt
     * the EPP server responds and then closes the connection with the client.
     */
    public function logout()
    {
        $this->loginCheck();

        $request = new Request('logout');

        $response = $this->processRequest($request);

        // TODO Do something with the response

        $this->loggedIn = false;
    }

    /**
     * Checks if a domain or set of domains are available.
     *
     * The <check> command is used to determine if the domain name is currently
     * registered and provides a hint about whether a <check> command would be
     * successful.
     *
     * @param string|array $domains
     */
    public function checkDomain($domains)
    {
        $this->loginCheck();

        $request = new Request\Check\Domain();

        $request->lookup($domains);

        $response = $this->processRequest($request);

        return $response->getValues();
    }

    /**
     * Checks if a contact or set of contacts are available.
     *
     * The check command is used to determine if the domain name is currently
     * registered and provides a hint about whether a <check> command would be
     * successful.
     *
     * @param string|array $contactIds
     */
    public function checkContact($contactIds)
    {
        $this->loginCheck();

        $request = new Request\Check\Contact();

        $request->lookup($contactIds);

        $response = $this->processRequest($request);

        return $response;
    }

    /**
     * Checks if a host or set of hosts are available.
     *
     * The <check> command is used to determine if the domain name is currently
     * registered and provides a hint about whether a <check> command would be
     * successful.
     *
     * @param string|array $hosts
     */
    public function checkHost($hosts)
    {
        $this->loginCheck();

        $request = new Request\Check\Host();

        $request->lookup($hosts);

        $response = $this->processRequest($request);

        return $response;
    }

    /**
     * The <create> command allows you to create a contact
     * account.
     *
     * @param \SclNominetEpp\Contact $contact
     */
    public function createContact(Contact $contact)
    {
        $this->loginCheck();

        $request = new Request\Create\Contact();
        $request->setContact($contact);
        $request->lookup($contact->getId());
        $response = $this->processRequest($request);

        return $response->success();
    }

    /**
     * The <create> command allows you to register a domain name or to create an
     * account or nameserver object to link to domain names.
     *
     * @param \SclNominetEpp\Domain $domain
     */
    public function createDomain(Domain $domain)
    {
        $this->loginCheck();

        $request = new Request\Create\Domain();
        $request->setDomain($domain);
        $request->lookup($domain->getName());

        $response = $this->processRequest($request);

        return $response->success();
    }

    /**
     * The <create> command allows you to create a nameserver object to link to domain names.
     *
     * @param \SclNominetEpp\Nameserver $host
     */
    public function createHost(Nameserver $host)
    {
        $this->loginCheck();
        $request = new Request\Create\Host($host);
        $request->setNameserver($host);
        $request->lookup($host->getHostName);
        $response = $this->processRequest($request);

        return $response->success();
    }

    /**
     * The EPP <delete> command allows the registrar to delete a domain name.
     * Further details of this are available in RFC 5731 The delete command may
     * not be used to delete nameservers and accounts.
     */
    public function deleteDomain(Domain $domain)
    {
        $this->loginCheck();
        $request  = new Request\Delete\Domain($domain);
        $response = $this->processRequest($request);
        
        return $response->success();
    }
    
    /**
     * The EPP <delete> command allows the registrar to delete a domain name.
     * Further details of this are available in RFC 5731 The delete command may
     * not be used to delete nameservers and accounts.
     */
    public function deleteContact()
    {
        $this->loginCheck();
        $request  = new Request\Delete\Contact($contact);
        $response = $this->processRequest($request);
        
        return $response->success();
    }

    /**
     * The <renew> command only applies to domain names. It has no meaning for
     * other object types.
     *
     * @param string $domain The domain to be renewed
     * @param \DateTime|NULL The new expiry data or NULL
     */
    public function renew($domain, $expDate)
    {
        $this->loginCheck();

        $request = new Request\Renew();
        $request->setDomain($domain, $expDate);

        $response = $this->processRequest($request);

        return $response;
    }

    /**
     * The <unrenew> operation is used to reverse a renewal request made for a
     * domain name. The renew command only applies to domain names. It has no
     * meaning for other object types.
     */
    public function unrenew()
    {
        $this->loginCheck();
    }

    /**
     * The <update> operation allows the attributes of an object to be updated.
     * @param Domain $domain The Domain to be updated.
     */
    public function updateDomain(Domain $domain)
    {
        $this->loginCheck();
        $request = new Request\Update\Domain($domain->getName());
        $request->setDomain($domain);
        
        $currentDomain = $this->domainInfo($domain->getName()); //used to input data into the system.
        if (!$currentDomain instanceof Domain) {
            throw new Exception("The domain requested for updating is unregistered.");
        }
        $currentNameservers = $currentDomain->getNameservers();
        $currentContacts    = $currentDomain->getContacts();
        $newNameservers     = $domain->getNameservers();
        $newContacts        = $domain->getContacts();
        
        $addContacts       = array_uintersect(
            $newContacts,
            $currentContacts,
            array('\SclNominetEpp\Request\Update\Helper\DomainCompareHelper', 'compare')
        );
        $removeContacts    = array_uintersect(
            $currentContacts,
            $newContacts,
            array('\SclNominetEpp\Request\Update\Helper\DomainCompareHelper', 'compare')
        );
        $addNameservers    = array_uintersect(
            $newNameservers,
            $currentNameservers,
            array('\SclNominetEpp\Request\Update\Helper\DomainCompareHelper', 'compare')
        );
        $removeNameservers = array_uintersect(
            $currentNameservers,
            $newNameservers,
            array('\SclNominetEpp\Request\Update\Helper\DomainCompareHelper', 'compare')
        );
        
        if (!empty($addNameservers)) {
            foreach ($addNameservers as $nameserver) {
                $request->add(new Update\Field\DomainNameserver($nameserver->getHostName()));
            }
        }
        
        if (!empty($addContacts)) {
            foreach ($addContacts as $type => $contact) {
                $request->add(new Update\Field\DomainContact($contact->getId(), $type));
            }
        }
        
        $request->add(new Update\Field\Status('Payment Overdue', self::STATUS_CLIENT_HOLD));
           
        if (!empty($removeNameservers)) {
            foreach ($removeNameservers as $nameserver) {
                $request->remove(new Update\Field\DomainNameserver($nameserver->getHostName()));
            }
        }
        
        if (!empty($removeContacts)) {
            foreach ($removeContacts as $type => $contact) {
                $request->remove(new Update\Field\DomainContact($contact->getId(), $type));
            }
        }
        
        //$request->remove(new Update\Field\DomainNameserver('ns1.example.com'));
        //$request->remove(new Update\Field\DomainContact('mak32', 'tech'));
        
        $response = $this->processRequest($request);

        return $response;
    }

    /**
     * The <update> operation allows the attributes of an object to be updated.
     * @param Contact $contact The contact to be updated.
     */
    public function updateContact(Contact $contact)
    {
        $this->loginCheck();
        
        $request = new Request\Update\Contact();
        
        $request->add(new Update\Field\Status('', self::STATUS_CLIENT_DELETE_PROHIBITED));
        
        $response = $this->processRequest($request);
        
        return $response;
    }
    
    /**
     * The <update> operation allows the attributes of an object to be updated.
     */
    public function updateContactID()
    {
        $this->loginCheck();

        $request = new Request\Update\ContactID();
        
        $request->add(new Update\Field\Status('', self::STATUS_CLIENT_HOLD));
        
        $response = $this->processRequest($request);

        return $response;
    }

    /**
     * The <update> operation allows the attributes of an object to be updated.
     * @param Nameserver $host The nameserver to be updated.
     */
    public function updateHost(Nameserver $host)
    {
        $this->loginCheck();
        
        $request = new Request\Update\Host($host->getHostName());
        
        $request->add(new Update\Field\Status('', self::STATUS_CLIENT_UPDATE_PROHIBITED));
        
        $request->add(new Update\Field\HostAddress('192.0.2.2', 'v4'));
        
        $response = $this->processRequest($request);
        
        return $response;
    }

    /**
     * The EPP <info> command is used to retrieve information associated with
     * an object.
     *
     * @param string  $domainName
     * @param boolean $recursive  If false only the domain info is fetch, if
     *     true the attached accounts and host info should be returned also.
     * @return Domain
     */
    public function domainInfo($domainName, $recursive = false)
    {
        $this->loginCheck();

        $request = new Request\Info\Domain();

        $request->lookup($domainName);

        $response = $this->processRequest($request);
        if (!$response->success()) {
            return false;
        }
        $domain = $response->getDomain();
        return $domain;
    }

    /**
     * The EPP <info> command is used to retrieve information associated with
     * an object. ($contactID is the $registrant from domainInfo)
     *
     * @param  string  $contactID
     * @return boolean
     */
    public function contactInfo($contactID)
    {
        $this->loginCheck();

        $request = new Request\Info\Contact();

        $request->lookup($contactID);

        $response = $this->processRequest($request);
        if (!$response->success()) {
            return false;
        }
        $contact = $response->getContact();

        return $contact;
    }

    /**
     * The EPP <info> command is used to retrieve information associated with
     * an object.
     *
     * @param  string $hostName
     * @return Nameserver|mixed
     */
    public function hostInfo($hostName)
    {
        $this->loginCheck();

        $request = new Request\Info\Host();

        $request->lookup($hostName);

        $response = $this->processRequest($request);
        $host = $response->getHost();

        return $host;
    }

    /**
     * When changes take place in the registration data for domain names or
     * ENUMs on a tag, we send notifications to the registrar. It will be
     * possible for registrars to elect to receive these notifications via EPP.
     *
     * If a registrar elects to receive notifications via EPP, then
     * notifications will be placed in the message queue awaiting a poll
     * command to retrieve them. If the message queue is not empty, then a
     * successful response to a poll command returns the first message from the
     * queue.  This response includes a unique message identifier and a counter
     * that gives the number of messages in the queue.
     *
     * After a message has been received by the client, the client must respond
     * to the client with an explicit acknowledgement to confirm that the
     * message has been received. Then that message is dequeued and the next
     * message in the queue becomes available for retrieval.
     *
     * NOTE: To use the <poll> command you must have activated this notification
     * option for your account in the Online Service. In addition, version 1.1
     * or subsequent schemas must be used if polling via Nominet EPP.
     */
    public function poll()
    {
        $this->loginCheck();
    }

    /**
     * The <transfer> command allows a registrar to request that a domain name
     * or account object to be transferred from another registrar.
     */
    //public function transfer()
    //{
    //    $this->loginCheck();
    //}

    /**
     * The <handshake> operation allows a registrar to accept or reject a
     * registrar change/registrant transfer authorisation request.
     */
    public function handshake()
    {
        $this->loginCheck();
    }

    /**
     * The <release> operation allows a registrar to move a domain name, or
     * account onto another tag.
     */
    public function release()
    {
        $this->loginCheck();
    }

    /**
     * The <fork> command allows a number of domain names on a registrant contact
     * to be moved to a copy of that contact.
     */
    public function fork()
    {
        $this->loginCheck();
    }

    /**
     * Retrieves a domain list.
     * NOTE: This method is called domainList as list is a resevered word :-(
     *
     * @param  integer    $year
     * @param  integer    $month
     * @param  integer|null    $type
     */
    public function listDomains($year, $month, $type = self::LIST_MONTH)
    {
        $this->loginCheck();

        if (!in_array($type, array(self::LIST_MONTH, self::LIST_EXPIRY))) {
            throw new \Exception("Invalid type $type.");
        }

        $request = new Request\ListDomains();
        $request->setDate($month, $year);

        $response = $this->processRequest($request);

        return $response->getDomains();
    }

    /**
     * The investigation <lock> command can be used to lock down a domain name,
     * preventing a number of operations upon it.
     */
    public function lock()
    {
        $this->loginCheck();
    }

    /**
     * The reseller create command is used to define a new reseller on your tag
     */
    public function resellerCreate()
    {
        $this->loginCheck();
    }

    /**
     * The reseller delete command is used to remove a reseller from your tag.
     */
    public function resellerDelete()
    {
        $this->loginCheck();
    }

    /**
     * The reseller info command returns all information associated with a
     * reseller on your tag.
     */
    public function resellerInfo()
    {
        $this->loginCheck();
    }

    /**
     * The reseller list command returns information about all resellers on
     * your tag.
     */
    public function resellerList()
    {
        $this->loginCheck();
    }

    /**
     * The reseller update command is used to modify the attributes of an
     * existing reseller on your tag.
     */
    public function resellerUpdate()
    {
        $this->loginCheck();
    }
}
