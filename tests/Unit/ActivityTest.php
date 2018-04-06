<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Activity;
use App\Item;
use Carbon\Carbon;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_activity_when_a_item_is_created()
    {
        $this->signIn();

        $item = factory(Item::class)->create();

        $this->assertDatabaseHas('activities', [
            'type' => 'items.created',
            'user_id' => auth()->id(),
            'subject_id' => $item->id,
            'subject_type' => get_class($item),
        ]);

        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $item->id);
    }

    /** @test */
    public function it_records_activity_when_a_item_is_updated()
    {
        $this->signIn();

        $item = factory(Item::class)->create();

        $old_name = $item->name;
        $new_name = 'new name';

        $item->name = $new_name;
        $item->save();

        $this->assertDatabaseHas('activities', [
            'type' => 'items.updated',
            'user_id' => auth()->id(),
            'subject_id' => $item->id,
            'subject_type' => get_class($item),
            'before' => json_encode(['name' => $old_name]),
            'after' => json_encode(['name' => $new_name]),
        ]);

        $activity = Activity::where('type', 'items.updated')
            ->first();

        $this->assertEquals($activity->subject->id, $item->id);
    }

    /** @test */
    public function it_records_activity_when_a_item_is_deleted()
    {
        $this->signIn();

        $item = factory(Item::class)->create();

        $item->delete();

        $this->assertDatabaseHas('activities', [
            'type' => 'items.deleted',
            'user_id' => auth()->id(),
            'subject_id' => $item->id,
            'subject_type' => get_class($item),
        ]);

        $activity = Activity::where('type', 'items.deleted')
            ->first();

        // TODO: when delete item, subject->id should be tracked
        //$this->assertEquals($activity->subject->id, $item->id);
    }
}
