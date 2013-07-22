<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.3                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2013                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License along with this program; if not, contact CiviCRM LLC       |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

require_once 'CiviTest/CiviSeleniumTestCase.php';
class WebTest_Contact_TaskActionAddToCustomGroupTest extends CiviSeleniumTestCase {

  protected function setUp() {
    parent::setUp();
  }


  function testSmartGroup() {
    $this->webtestLogin();
    $newGroupName = 'testEDS3_' . substr(sha1(rand()), 0, 7);
   
    $this->openCiviPage('contact/search/advanced', 'reset=1');
    $this->select("crmasmSelect0", "value=Individual");
    $this->click("_qf_Advanced_refresh");
    $this->waitForPageToLoad($this->getTimeoutMsec());

    $this->click("toggleSelect");
    $this->select("task", "label=New Smart Group");
    sleep(1);
    $this->click("Go");
    $this->waitForPageToLoad($this->getTimeoutMsec());

    // Define name for the New smart group

    $this->type("title", $newGroupName);
    $this->click("_qf_SaveSearch_next-bottom");	
    $this->waitForPageToLoad($this->getTimeoutMsec());

    // Check status messages are as expected
    $this->waitForText('crm-notification-container', "Your smart group has been saved as '{$newGroupName}'");

    $this->click("_qf_Result_done");
    $this->waitForPageToLoad($this->getTimeoutMsec());
    
    // Edit Advance search 
    $this->click('css=div.crm-advanced_search_form-accordion div.crm-accordion-header');
    $this->click("xpath=//ul[@id='crmasmList0']/li/a");	
    $this->select("crmasmSelect0", "value=Household");
    $this->click("_qf_Advanced_refresh");
    $this->waitForPageToLoad($this->getTimeoutMsec());
    $this->click('_qf_Advanced_refresh');
    $this->waitForPageToLoad(2 * $this->getTimeoutMsec());
    $this->click("toggleSelect");  
    $this->select("task", "label=Add Contacts to Group");
    sleep(1);
    $this->click('Go');
    $this->waitForPageToLoad($this->getTimeoutMsec());


    // Select the new group and click to add
    $this->click("group_id");
    $this->select("group_id", "label=" . $newGroupName);
    $this->click("_qf_AddToGroup_next-bottom");
    
    // Check status messages are as expected
    $this->waitForText('crm-notification-container', "Added Contacts to {$newGroupName}");

  }
}

