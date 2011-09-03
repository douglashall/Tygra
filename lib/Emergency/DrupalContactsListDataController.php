<?php

class DrupalContactsListDataController extends ContactsListDataController
{
    protected $DEFAULT_PARSER_CLASS = 'DrupalContactsDataParser';
    protected $contactsLoaded = FALSE;

    protected function loadContacts() {
        if(!$this->contactsLoaded) {
            $contacts = $this->getParsedData();
            $this->primaryContacts = $contacts['primary'];
            $this->secondaryContacts = $contacts['secondary'];
            $this->contactsLoaded = TRUE;
        }
    }

    protected function init($args) {
        if (!isset($args['DRUPAL_SERVER_URL'])) {
            throw new Exception("DRUPAL_SERVER_URL not set");
        }

        if (!isset($args['FEED_VERSION'])) {
            throw new Exception("FEED_VERSION not set");
        }
        
        $args['BASE_URL'] = $args['DRUPAL_SERVER_URL'] .
            "/emergency-contacts-v" . $args['FEED_VERSION'];
        parent::init($args);
    }
}