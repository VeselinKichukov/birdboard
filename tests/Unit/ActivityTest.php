<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   function it_has_a_user()
   {
       $user = $this->signIn();

       $project = ProjectFactory::ownedBy($user)->create();

       $this->assertEquals($user->id, $project->activity->first()->user->id);
   }
}
