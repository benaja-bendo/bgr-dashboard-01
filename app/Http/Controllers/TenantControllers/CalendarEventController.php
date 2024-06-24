<?php

namespace App\Http\Controllers\TenantControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarEventCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\IcalendarGenerator\Components\Calendar as CalendarSpatie;
use Spatie\IcalendarGenerator\Components\Event as EventSpatie;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $calendarEvents = \App\Models\CalendarEvent::all();
        return $this->successResponse(
            data: new CalendarEventCollection($calendarEvents),
            message: 'Calendar events retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Export the specified resource.
     */
    public function export(string $user_id)
    {
        // TODO: Implement export method
        // Fausse donnée pour les événements du calendrier
        $events = [
            [
                'title' => 'Meeting with Client',
                'description' => 'Discuss project requirements and milestones.',
                'start' => now()->addDays(1),
                'end' => now()->addDays(1)->addHours(2),
            ],
            [
                'title' => 'Team Standup',
                'description' => 'Daily team standup meeting.',
                'start' => now()->addDays(2),
                'end' => now()->addDays(2)->addMinutes(30),
            ],
            [
                'title' => 'Code Review',
                'description' => 'Review code for the new feature.',
                'start' => now()->addDays(3),
                'end' => now()->addDays(3)->addHours(1),
            ],
        ];


        // Création du calendrier
        $calendar = CalendarSpatie::create('User Calendar')
            ->description('A calendar with some fake events for the user')
            ->productIdentifier('my-app');

        // Ajout des événements au calendrier
        foreach ($events as $eventData) {
            $event = EventSpatie::create($eventData['title'])
                ->description($eventData['description'])
                ->startsAt($eventData['start'])
                ->endsAt($eventData['end']);

            $calendar->event($event);
        }

        // Définir le nom du fichier .ics
        $fileName = 'user_calendar_' . $user_id . '.ics';

        // Retourner le fichier .ics en réponse
        return response($calendar->get())
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
