<?php

use App\Models\User;
use App\Models\Truck;

use App\Models\ShipmentPermit;
use function Pest\Laravel\get;
use Filament\Actions\DeleteAction;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('a user can view shipment permits', function () {
    $user = User::factory()->create(['role' => 'admin']);
    actingAs($user,'web');
    $response = get('/admin/shipment-permits');
    $response->assertStatus(200);
});

test('a user can view the shipment permit create page', function () {
    $user = User::factory()->create(['role' => 'admin']);
    actingAs($user);
    $response = get('/admin/shipment-permits/create');
    $response->assertStatus(200);
});

test('a user can create a shipment permit', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $driver = User::factory()->create(['role' => 'driver']);
    $truck = Truck::factory()->create();
    actingAs($admin);
    
    $response = livewire(\App\Filament\Resources\ShipmentPermitResource\Pages\CreateShipmentPermit::class)
        ->set('data.permit_number', 'CH-12345')
        ->set('data.truck_id', $truck->id)
        ->set('data.driver_id', $driver->id)
        ->set('data.shipment_date', now()->toDateString())
        ->set('data.shipment_from', 'Jakarta')
        ->set('data.shipment_to', 'Bandung')
        ->set('data.shipment_type', 'Export')
        ->set('data.shipment_status', 'pending')
        ->set('data.file_path', ['storage/shipment_permits/CH-12345.pdf'])
        ->call('create');
    $response->assertHasNoErrors();

    //check if the shipment permit is created
    $this->assertDatabaseHas('shipment_permits', [
        'permit_number' => 'CH-12345',
        'truck_id' => $truck->id,
        'driver_id' => $driver->id,
        'shipment_date' => now()->toDateString(),
        'shipment_from' => 'Jakarta',
        'shipment_to' => 'Bandung',
        'shipment_type' => 'Export',
        'shipment_status' => 'pending',
        'file_path' => ['storage/shipment_permits/CH-12345.pdf']
    ]);
});

test('a user can view edit shipment permit page', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $driver = User::factory()->create(['role' => 'driver']);
    $truck = Truck::factory()->create();
    actingAs($user);
    
    $shipmentPermit = ShipmentPermit::factory()->create();
    actingAs($user);
    $response = get('/admin/shipment-permits/' . $shipmentPermit->id . '/edit');
    $response->assertStatus(200);
});

test('a user can update a shipment permit', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $driver = User::factory()->create(['role' => 'driver']);
    $truck = Truck::factory()->create();
    actingAs($admin);
    
    $shipmentPermit = ShipmentPermit::factory()->create();
    $response = livewire(\App\Filament\Resources\ShipmentPermitResource\Pages\EditShipmentPermit::class, ['record' => $shipmentPermit->id])
        ->set('data.permit_number', $shipmentPermit->permit_number)
        ->set('data.truck_id', $shipmentPermit->truck_id)
        ->set('data.driver_id', $shipmentPermit->driver_id)
        ->set('data.shipment_date', now()->toDateString())
        ->set('data.shipment_from', 'Jakarta')
        ->set('data.shipment_to', 'Bandung')
        ->set('data.shipment_type', 'export')
        ->set('data.shipment_status', 'pending')
        ->set('data.file_path', ['storage/shipment_permits/CH-12345.pdf'])
        ->call('save');
        
    $response->assertHasNoErrors();

    //check if the shipment permit is updated
    $this->assertDatabaseHas(ShipmentPermit::class, [
        'permit_number' => $shipmentPermit->permit_number,
        'truck_id' => $shipmentPermit->truck_id,
        'driver_id' => $shipmentPermit->driver_id,
        'shipment_date' => now()->toDateString(),
        'shipment_from' => 'Jakarta',
        'shipment_to' => 'Bandung',
        'shipment_type' => 'export',
        'shipment_status' => 'pending',
        //assert file path from data
        'file_path' => 'storage/shipment_permits/CH-12345.pdf'
    ]);
});

test('a user can delete a shipment permit', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $driver = User::factory()->create(['role' => 'driver']);
    $truck = Truck::factory()->create();
    $shipmentPermit = ShipmentPermit::factory()->create();
    actingAs($admin);

    livewire(\App\Filament\Resources\ShipmentPermitResource\Pages\EditShipmentPermit::class, ['record' => $shipmentPermit->getRouteKey()])
        ->callAction(DeleteAction::class);
    $this->assertDatabaseMissing($shipmentPermit);
    

});