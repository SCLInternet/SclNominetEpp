<?php
/**
 * Contains the Nominet class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp;

use RequestResponse\AbstractRequestResponse;
use RequestResponse\RequestInterface;
use RequestResponse\ResponseInterface;

use SclNominetEpp\Exception\LoginRequiredException;
use SclNominetEpp\Address;

use SclNominetEpp\Request;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * This class exposes all the actions of the Nominet EPP system in a nice PHP
 * class.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Nominet extends AbstractRequestResponse implements
    ServiceLocatorAwareInterface
{
    const LIST_MONTH  = 1;
    const LIST_EXPIRY = 2;

    /**
     * Flag that states whether we are logged into Nominet or not.
     *
     * @var boolean
     */
    private $loggedIn = false;

    /**
     * The Zend service locator.
     *
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

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
     * Set the service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        $this->setCommunicator($serviceLocator->get('SclNominetEpp\Communicator'));
    }

    /**
     * Return the service locator.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
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
     * The login command is used to establish and authenticate a session with
     * the EPP server. The login command must be sent to the server before any
     * other EPP command and identifies and authenticates the tag to be used
     * by the session. An EPP session is terminated by a logout command.
     *
     * @param string $tag
     * @param string $password
     * @param string $newPassword If specified with change the password.
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
     * The hello command is used to obtain a greeting element from our server
     * and may be used to keep your connection with our EPP server open.
     * Sending an EPP hello command every 59 minutes will keep your connection
     * with our EPP server open.
     */
    public function hello()
    {
        $this->loginCheck();

        $request = new Request\Request('hello');

        $response = $this->processRequest($request);

        // TODO Do something with the response
    }

    /**
     * A logout command is used to end a session with an EPP server. On receipt
     * the EPP server responds and then closes the connection with the client.
     */
    public function logout()
    {
        $this->loginCheck();

        $request = new Request\Request('logout');

        $response = $this->processRequest($request);

        // TODO Do something with the response

        $this->loggedIn = false;
    }

    /**
     * Checks if a domain or set of domains are available.
     *
     * The check command is used to determine if the domain name is currently
     * registered and provides a hint about whether a <create> command would be
     * successful.
     *
     * @param string|array $domains
     */
    public function checkDomain($domains)
    {
        $this->loginCheck();

        $request = new Request\CheckDomain();

        $request->lookup($domains);

        $response = $this->processRequest($request);

        return $response->getDomains();
    }

    /**
     * Checks if a contact or set of contacts are available.
     *
     * The check command is used to determine if the domain name is currently
     * registered and provides a hint about whether a <create> command would be
     * successful.
     *
     * @param string|array $contactIds
     */
    public function checkContact($contactIds)
    {
        $this->loginCheck();

        $request = new Request\CheckContact();

        $request->lookup($contactIds);

        $response = $this->processRequest($request);

        return $response;
    }

    /**
     * Checks if a host or set of hosts are available.
     *
     * The check command is used to determine if the domain name is currently
     * registered and provides a hint about whether a <create> command would be
     * successful.
     *
     * @param string|array $hosts
     */
    public function checkHost($hosts)
    {
        $this->loginCheck();

        $request = new Request\CheckHost();

        $request->lookup($hosts);

        $response = $this->processRequest($request);

        return $response;
    }

    /**
     * The create command allows you to register a domain name or to create an
     * account or nameserver object to link to domain names.
     *
     * @param \SclNominetEpp\Domain $domain
     */
    public function createContact()//Contact $contact)
    {
        $this->loginCheck();

        $contact = new Contact();
        $contact->setId('sc2343');
        $contact->setName('name');
        $contact->setEmail('example@email.com');

        /*
        * The contact address.
        * which comprises of the (addressLineOne, city, cc, addressLineTwo, addressLineThree, sp, pc);
        *
        */
        $address = new Address('Bryn Seion Chapel', 'Cardigan', 'US', null, null, 'Ceredigion', 'SA43 2HB');
        $contact->setAddress($address);

        $contact->setCompanyNumber('NI65786');
        // The registered company number or the DfES UK school number of the registrant.
        $contact->setPhone('+44.3344555666');
        $contact->setOrg('sclMerlyn');
        $contact->setFax('+443344555616');
        $contact->setOptOut('y');


        $request = new Request\CreateContact($contact);

        //$request->lookup($hosts);
        $response = $this->processRequest($request);


        return $response->success();
    }

    /**
     * The create command allows you to register a domain name or to create an
     * account or nameserver object to link to domain names.
     *
     * @param \SclNominetEpp\Domain $domain
     */
    public function createDomain(Domain $domain)
    {
        $this->loginCheck();

        $request = new Request\CreateDomain();
        $request->setDomain($domain);

        $response = $this->processRequest($request);

        return $response->success();
    }

    public function createHost()
    {
        $this->loginCheck();

        $name = 'ns1.example.com.';
        $ipv4 = '192.0.2.2';
        $ipv6 = '1080:0:0:0:8:800:200C:417A';

        $host = new Nameserver($name, $ipv4, $ipv6);

        $request = new Request\CreateHost($host);

        $response = $this->processRequest($request);

        return $response->success();
    }

    /**
     * The EPP delete command allows the registrar to delete a domain name.
     * Further details of this are available in RFC 5731 The delete command may
     * not be used to delete nameservers and accounts.
     */
    public function delete()
    {
        $this->loginCheck();
    }

    /**
     * The renew command only applies to domain names. It has no meaning for
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
     * The unrenew operation is used to reverse a renewal request made for a
     * domain name. The renew command only applies to domain names. It has no
     * meaning for other object types.
     */
    public function unrenew()
    {
        $this->loginCheck();
    }

    /**
     * The update operation allows the attributes of an object to be updated.
     */
    public function updateDomain()
    {
        $this->loginCheck();
        $request = new Request\UpdateDomain();

        $response = $this->processRequest($request);

        return $response;
    }

    /**
     * The update operation allows the attributes of an object to be updated.
     */
    public function updateContact()
    {
        $this->loginCheck();
    }

    public function updateContactID()
    {
        $this->loginCheck();
    }

    /**
     * The EPP <info> command is used to retrieve information associated with
     * an object.
     *
     * @param string $domainName
     * @param boolean $recursive If false only the domain info is fetch, if
     *     true the attached accounts and host info should be returned also.
     * @return Domain
     */
    public function domainInfo($domainName, $recursive = false)
    {
        $this->loginCheck();

        $request = new Request\DomainInfo();

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
     * @param string $contactID
     * @return boolean
     */
    public function contactInfo($contactID)
    {
        $this->loginCheck();

        $request = new Request\ContactInfo();

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
     * @param string $hostName
     * @return type
     */
    public function hostInfo($hostName)
    {
        $this->loginCheck();

        $request = new Request\HostInfo();

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
     * NOTE: To use the poll command you must have activated this notification
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
    public function transfer()
    {
        $this->loginCheck();
    }

    /**
     * The handshake operation allows a registrar to accept or reject a
     * registrar change/registrant transfer authorisation request.
     */
    public function handshake()
    {
        $this->loginCheck();
    }

    /**
     * The release operation allows a registrar to move a domain name, or
     * account onto another tag.
     */
    public function release()
    {
        $this->loginCheck();
    }

    /**
     * The fork command allows a number of domain names on a registrant contact
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
     * @param integer $year
     * @param integer $month
     * @param integer $type
     * @return array|NULL The list of the domains or null on failure.
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
     * The investigation lock command can be used to lock down a domain name,
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
