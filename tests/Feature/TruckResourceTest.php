<?php
use App\Models\User;
use App\Models\Truck;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\actingAs;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TruckResource;
use App\Filament\Resources\TruckResource\Pages\EditTruck;
use Livewire\Livewire;
use Illuminate\Foundation\Application;
use Filament\Actions\DeleteAction;
use function Pest\Livewire\livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can view the trucks index page', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    // Gunakan guard "web" secara eksplisit
    actingAs($admin, 'web');

    $response = get('/admin/trucks');
    $response->assertStatus(200);
});

it('can view the trucks create page', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    // Gunakan guard "web" secara eksplisit
    actingAs($admin, 'web');

    $response = get('/admin/trucks/create');
    $response->assertStatus(200);
});

it('can create a truck', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    actingAs($admin);

    Livewire::test(\App\Filament\Resources\TruckResource\Pages\CreateTruck::class)
        ->set('data.plate_number', 'B 1234 XYZ') // 🔄 Ubah dari 'license_plate' ke 'plate_number'
        ->set('data.brand', 'Hino')
        ->set('data.model', 'FM 260 JD')
        ->set('data.year', 2021)
        ->set('data.last_maintenance', now()->toDateString())
        ->set('data.status', 'active')
        ->call('create')
        ->assertHasNoErrors();

    expect(Truck::count())->toBe(1);
});

it('can update a truck', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    actingAs($admin);

    // 🚧 Buat data truck
    $truck = Truck::factory()->create();

    Livewire::test(\App\Filament\Resources\TruckResource\Pages\EditTruck::class, ['record' => $truck->id]) // ✅
        ->set('data.plate_number', 'B 1234 XYZ')
        ->set('data.brand', 'Hino')
        ->set('data.model', 'FM 260 JD')
        ->set('data.year', 2021)
        ->set('data.last_maintenance', now()->toDateString())
        ->set('data.status', 'active')
        ->call('save') // ✅ Filament menggunakan metode save()
        ->assertHasNoErrors();

    expect(Truck::count())->toBe(1);
    expect(Truck::first()->plate_number)->toBe('B 1234 XYZ');
});

it('can delete a truck', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    actingAs($admin);

    // 🚧 Buat data truck
    $truck = Truck::factory()->create();

    Livewire::test(EditTruck::class, ['record' => $truck->getRouteKey()])
        //call action
        ->callAction(DeleteAction::class)
        ->assertHasNoErrors();
});


