<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('Donate');
$I->amOnPage('/posts/1/donate');
$I->see('Go back to the posts');
$I->fillField('msisdn','0722123127');
$I->fillField('amount',1000);
$I->fillField('pin',0987);
$I->click('donate');
