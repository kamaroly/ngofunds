<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('Nagivate the home page');
$I->amOnPage('/');
$I->see('NGos Funds');
$I->click('Browse Post');
$I->seeInCurrentUrl('posts');
