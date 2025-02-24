<?php

use App\Models\User;
use App\Models\Truck;
use App\Models\TruckReport;
use Filament\Actions\DeleteAction;

use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('a user can view the truck report resource', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    // Gunakan guard "web" secara eksplisit
    actingAs($admin, 'web');
    $response = get('/admin/truck-reports');
    $response->assertStatus(200);
});

test('a user can view the truck report create page', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    // Gunakan guard "web" secara eksplisit
    actingAs($admin, 'web');
    $response = get('/admin/truck-reports/create');
    $response->assertStatus(200);
});

test('a user can create a truck report', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $driver = User::factory()->create(['role' => 'driver']);
    $truck = Truck::factory()->create();
    actingAs($admin);

    livewire(\App\Filament\Resources\TruckReportResource\Pages\CreateTruckReport::class)
        ->set('data.truck_id', $truck->id)
        ->set('data.driver_id', $driver->id)
        ->set('data.report_date', now()->toDateString())
        ->set('data.engine_status', 'good')
        ->set('data.tires_status', 'good')
        ->set('data.oil_status', 'good')
        ->set('data.brakes_status', 'good')
        ->set('data.lights_status', 'good')
        ->set('data.battery_status', 'good')
        ->set('data.coolant_status', 'good')
        ->set('data.transmission_status', 'good')
        ->set('data.steering_status', 'good')
        ->set('data.suspension_status', 'good')
        ->set('data.fuel_status', 'full')
        ->set('data.notes', 'Lorem ipsum dolor sit amet')
        ->set('data.approval_status', 'pending')
        ->set('data.approved_by', $admin->id)
        ->call('create')
        ->assertHasNoErrors();
        
    $this->assertDatabaseHas(TruckReport::class, [
        'truck_id' => $truck->id,
        'driver_id' => $driver->id,
        'report_date' => now()->toDateString(),
        'engine_status' => 'good',
        'tires_status' => 'good',
        'oil_status' => 'good',
        'brakes_status' => 'good',
        'lights_status' => 'good',
        'battery_status' => 'good',
        'coolant_status' => 'good',
        'transmission_status' => 'good',
        'steering_status' => 'good',
        'suspension_status' => 'good',
        'fuel_status' => 'full',
        'notes' => 'Lorem ipsum dolor sit amet',
        'approval_status' => 'pending',
        'approved_by' => $admin->id,
    ]);
});

test('a user can view the truck report edit page', function () {
    $admin = User::factory()->create(['role' => 'admin']); // Buat admin
    $driver = User::factory()->create(['role' => 'driver']); // Buat driver
    $truck = Truck::factory()->create(); // Buat truck

    // Gunakan guard "web" secara eksplisit
    actingAs($admin, 'web');
    $truckReport = TruckReport::factory()->create();
    $response = get("/admin/truck-reports/{$truckReport->id}/edit");
    $response->assertStatus(200);
});

test('a user can update a truck report', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $driver = User::factory()->create(['role' => 'driver']);
    $truck = Truck::factory()->create();
    $truckReport = TruckReport::factory()->create();
    actingAs($admin);

    livewire(\App\Filament\Resources\TruckReportResource\Pages\EditTruckReport::class, ['record' => $truckReport->id])
        ->set('data.truck_id', $truck->id)
        ->set('data.driver_id', $driver->id)
        ->set('data.report_date', now()->toDateString())
        ->set('data.engine_status', 'good')
        ->set('data.tires_status', 'good')
        ->set('data.oil_status', 'good')
        ->set('data.brakes_status', 'good')
        ->set('data.lights_status', 'good')
        ->set('data.battery_status', 'good')
        ->set('data.coolant_status', 'good')
        ->set('data.transmission_status', 'good')
        ->set('data.steering_status', 'good')
        ->set('data.suspension_status', 'good')
        ->set('data.fuel_status', 'full')
        ->set('data.notes', 'Lorem ipsum dolor sit amet')
        ->set('data.approval_status', 'pending')
        ->set('data.approved_by', $admin->id)
        ->call('save')
        ->assertHasNoErrors();
        
    $this->assertDatabaseHas(TruckReport::class, [
        'truck_id' => $truck->id,
        'driver_id' => $driver->id,
        'report_date' => now()->toDateString(),
        'engine_status' => 'good',
        'tires_status' => 'good',
        'oil_status' => 'good',
        'brakes_status' => 'good',
        'lights_status' => 'good',
        'battery_status' => 'good',
        'coolant_status' => 'good',
        'transmission_status' => 'good',
        'steering_status' => 'good',
        'suspension_status' => 'good',
        'fuel_status' => 'full',
        'notes' => 'Lorem ipsum dolor sit amet',
        'approval_status' => 'pending',
        'approved_by' => $admin->id,
    ]);
});

test('a user can delete a truck report', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $truckReport = TruckReport::factory()->create();
    actingAs($admin);

    livewire(\App\Filament\Resources\TruckReportResource\Pages\EditTruckReport::class, ['record' => $truckReport->getRouteKey()])
        ->callAction(DeleteAction::class);
    $this->assertDatabaseMissing($truckReport);
});