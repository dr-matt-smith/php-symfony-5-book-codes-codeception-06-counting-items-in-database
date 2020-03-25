<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class RecipeCest
{
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/recipe/new');
        $I->fillField('#recipe_title', 'Boston Cheesecake');
        $I->fillField('#recipe_steps', 'buy packet - follow instructions');
        $I->fillField('#recipe_time', 60);

        $I->click('Save');

    }

//    public function countRecipesBeforeChanges(AcceptanceTester $I)
//    {
//        // --- expect 1 in DB from fixtures
//        // arrange
//        $expectedCount = 1;
//
//        // act
//        $recipes = $I->grabEntitiesFromRepository('App\Entity\Recipe');
//        $numRecipes = count($recipes);
//
//        // assert
//        $I->assertEquals($expectedCount, $numRecipes);
//    }

    public function countOneMoreAfterCreate(AcceptanceTester $I)
    {
        $recipes = $I->grabEntitiesFromRepository('App\Entity\Recipe');
        $countbeforeInsert = count($recipes);

        $I->amOnPage('/recipe/new');
        $I->fillField('#recipe_title', 'Boston Cheesecake');
        $I->fillField('#recipe_steps', 'buy packet - follow instructions');
        $I->fillField('#recipe_time', 60);

        $I->click('Save');

        $recipes = $I->grabEntitiesFromRepository('App\Entity\Recipe');
        $countAfterInsert = count($recipes);

        $I->assertEquals($countAfterInsert, (1 + $countbeforeInsert));
    }

    public function randomValueInDbAfterInset(AcceptanceTester $I)
    {
        // (1) Arrange
        $randomNumber = rand(1, 100);
        // e.g. 'cheesecake99'
        $randomRecipeTitle = "cheesecake" . $randomNumber;

        // (2) Act
        $I->amOnPage('/recipe/new');
        $I->fillField('#recipe_title', $randomRecipeTitle);
        $I->fillField('#recipe_steps', 'buy packet - follow instructions');
        $I->fillField('#recipe_time', 60);

        $I->click('Save');

        // (3) Assert
        $I->seeInRepository('App\Entity\Recipe', [
            'title' => $randomRecipeTitle
        ]);
    }


}
