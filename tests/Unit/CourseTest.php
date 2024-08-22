<?php

use App\Models\Course;

it('returns true when the course is premium', function () {
    $course = new Course(['is_premium' => true]);

    expect($course->isPremium())->toBeTrue();
});

it('returns false when the course is not premium', function () {
    $course = new Course(['is_premium' => false]);

    expect($course->isPremium())->toBeFalse();
});

it('returns the formatted name in uppercase', function () {
    $course = new Course(['name' => 'Laravel']);

    expect($course->getFormattedName())->toBe('LARAVEL');
});
