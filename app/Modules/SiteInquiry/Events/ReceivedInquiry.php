<?php

namespace App\Modules\SiteInquiry\Events;

use App\Modules\Property\Property;
use App\Modules\Property\PropertyService;
use App\Modules\SiteInquiry\SiteInquiry;
use App\Modules\User\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class ReceivedInquiry
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SiteInquiry $inquiry;
    public User $agent;
    public Property $property;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SiteInquiry $inquiry)
    {
        $this->inquiry = $inquiry;

        $propertyService = App::make(PropertyService::class);
        $property = $propertyService->getOne($inquiry->property_id, ['relations' => 'assignee']);
        $this->property = $property;
        $this->agent = $property->assignee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
