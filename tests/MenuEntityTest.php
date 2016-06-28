<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\MenuEntity;

class MenuEntityTest extends TestCase
{
    /**
    * @test
     */
    public function it_can_return_a_menu_by_its_name()
    {
        $menu = new MenuEntity();
        var_dump($menu->getMenuByName('top_menu'));
    }
}
