<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateVehicleFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-vehicle-features';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Fetch all vehicles
        $vehicles = \App\Models\Vehicle::all();

        foreach ($vehicles as $vehicle) {
            // Check if the vehicle has features
            if (isset($vehicle->features) && is_array($vehicle->features)) {
                foreach ($vehicle->features as $feature) {
                    $this->info('Migrating vehicle features...');
                    // Create a new VehicleFeature instance
                    $title = is_array($feature['title']) ? $feature['title'][0] : $feature['title'];
                    $description = is_array($feature['description']) ? $feature['description'][0] : $feature['description'];

                    \App\Models\VehicleFeature::create([
                        'vehicle_id' => $vehicle->id,
                        'title' => $title,
                        'description' => $description,
                        'image' => is_array($feature['image']) ? reset($feature['image']) : ($feature['image'] ?? null),
                        'order' => $feature['order'] ?? 0,
                    ]);
                }
            }
        }

        $this->info('Vehicle features migrated successfully.');
    }
}
