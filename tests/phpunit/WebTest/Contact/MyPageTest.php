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
class WebTest_Contact_MyPageTest extends CiviSeleniumTestCase {

  protected function setUp() {
    parent::setUp();
  }


  function testMyPage() {
    $this->webtestLogin();
    
    $this->openCiviPage('mypage2/edit', 'reset=1');
    
    // Define updated test values for mypage
    $random = substr(sha1(rand()), 0, 7);
    $firstname = "Vivek".$random;
    $this->type("first_name", "Vivek".$random);
    $this->type("middle_name", "Prakash".$random);
    $this->type("last_name", "Arora".$random);
    $this->type("custom_9", "123".$random);
    $this->type("email", "vivek".$random."@gmail.com");
    $this->type("phone", "12".$random);
 
    $this->click("_qf_EditLoggedInUser_submit-top");	
    $this->waitForPageToLoad($this->getTimeoutMsec());

    // Check status messages are as expected
    $this->waitForText('crm-notification-container', "Contact updated $firstname");

  }
}

