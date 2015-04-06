<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('View the report');
$I->amOnPage('/');
$I->click('Please help to support children who get burned by accident');
$I->seeInCurrentUrl('/posts/1/view');
$I->see('Donate');

