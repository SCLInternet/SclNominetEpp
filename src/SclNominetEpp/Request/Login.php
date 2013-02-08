<?php
/**
 * Contains the nominet Login request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\Login as LoginResponse;
use SclNominetEpp\Request;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP login command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Login extends Request
{
    /**
     * The registrar tag.
     *
     * @var string
     */
    protected $tag;

    /**
     * The password to login with.
     *
     * @var string
     */
    protected $password;

    /**
     * The new password if the password is to be changed.
     *
     * @var string
     */
    protected $newPassword = null;

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct('login', new LoginResponse());
    }

    /**
     * Sets the login details for this.
     *
     * @param string $tag
     * @param string $password
     * @return Login
     */
    public function setCredentials($tag, $password)
    {
        $this->tag = $tag;
        $this->password = $password;

        return $this;
    }

    /**
     * Sets a new password for this account.
     *
     * @param string $newPassword
     */
    public function changePassword($newPassword)
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    /**
     * @param SimpleXMLElement
     * @param string $uri
     */
    private function addObjUri(SimpleXMLElement $xml, $uri)
    {
        $xml->addChild('objURI', $uri);
    }

    /**
     * @param SimpleXMLElement
     * @param string $uri
     */
    private function addSvcExtension(SimpleXMLElement $xml, $uri)
    {
        $xml->addChild(
            'extURI',
            'http://www.nominet.org.uk/epp/xml/' . $uri
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $xml->addChild('clID', $this->tag);
        $xml->addChild('pw', $this->password);

        if (null !== $this->newPassword) {
            $xml->addChild('newPw', $this->newPassword);
        }

        $options = $xml->addChild('options');

        $options->addChild('version', '1.0');
        $options->addChild('lang', 'en');

        $svcs = $xml->addChild('svcs');

        $this->addObjUri($svcs, 'urn:ietf:params:xml:ns:domain-1.0');
        $this->addObjUri($svcs, 'urn:ietf:params:xml:ns:contact-1.0');
        $this->addObjUri($svcs, 'urn:ietf:params:xml:ns:host-1.0');

        $svcExt = $svcs->addChild('svcExtension');

        // TODO Decide if we should load all these every time
        $this->addSvcExtension($svcExt, 'domain-nom-ext-1.2');
        $this->addSvcExtension($svcExt, 'contact-nom-ext-1.0');
        $this->addSvcExtension($svcExt, 'std-notifications-1.2');
        $this->addSvcExtension($svcExt, 'std-warning-1.1');
        $this->addSvcExtension($svcExt, 'std-contact-id-1.0');
        $this->addSvcExtension($svcExt, 'std-release-1.0');
        $this->addSvcExtension($svcExt, 'std-handshake-1.0');
        $this->addSvcExtension($svcExt, 'nom-abuse-feed-1.0');
        $this->addSvcExtension($svcExt, 'std-fork-1.0');
        $this->addSvcExtension($svcExt, 'std-list-1.0');
        $this->addSvcExtension($svcExt, 'std-locks-1.0');
        $this->addSvcExtension($svcExt, 'std-unrenew-1.0');
    }
}
