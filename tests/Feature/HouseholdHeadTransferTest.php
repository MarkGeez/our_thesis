<?php

namespace Tests\Feature;

use App\Models\FamilyMember;
use App\Models\House;
use App\Models\Household;
use App\Models\HouseholdResident;
use App\Models\Resident;
use App\Models\Street;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HouseholdHeadTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_head_transfer_updates_household_membership_and_resident_status(): void
    {
        $currentHeadUser = $this->createUser([
            'email' => 'current-head@example.com',
            'firstName' => 'Current',
            'middleName' => 'Head',
            'lastName' => 'Resident',
            'role' => 'resident',
        ]);

        $newHeadUser = $this->createUser([
            'email' => 'new-head@example.com',
            'firstName' => 'New',
            'middleName' => 'Head',
            'lastName' => 'Resident',
            'role' => 'resident',
        ]);

        $currentHeadResident = $this->createResident($currentHeadUser, [
            'firstName' => 'Current',
            'middleName' => 'Head',
            'lastName' => 'Resident',
            'headOfFamily' => 'yes',
        ]);

        $newHeadResident = $this->createResident($newHeadUser, [
            'firstName' => 'New',
            'middleName' => 'Head',
            'lastName' => 'Resident',
            'headOfFamily' => 'no',
        ]);

        $street = Street::create([
            'street_name' => 'Acacia Street',
        ]);

        $house = House::create([
            'street_id' => $street->id,
            'house_no' => '101',
            'property_type' => 'residential',
        ]);

        $household = Household::create([
            'house_id' => $house->id,
        ]);

        HouseholdResident::create([
            'household_id' => $household->id,
            'resident_id' => $currentHeadResident->id,
            'is_household_head' => true,
        ]);

        $familyMember = FamilyMember::create([
            'household_id' => $household->id,
            'resident_id' => $newHeadResident->id,
            'encoded_by' => $currentHeadUser->id,
            'relationship' => 'Spouse',
        ]);

        $response = $this->actingAs($currentHeadUser)
            ->from('/resident/profile')
            ->put(route('resident.update.head', $familyMember->id));

        $response->assertRedirect('/resident/profile');
        $response->assertSessionHas('success', 'Household head updated successfully.');

        $this->assertDatabaseHas('household_resident', [
            'household_id' => $household->id,
            'resident_id' => $currentHeadResident->id,
            'is_household_head' => 0,
        ]);

        $this->assertDatabaseHas('household_resident', [
            'household_id' => $household->id,
            'resident_id' => $newHeadResident->id,
            'is_household_head' => 1,
        ]);

        $this->assertDatabaseHas('residents', [
            'id' => $currentHeadResident->id,
            'headOfFamily' => 'no',
        ]);

        $this->assertDatabaseHas('residents', [
            'id' => $newHeadResident->id,
            'headOfFamily' => 'yes',
        ]);
    }

    private function createUser(array $overrides = []): User
    {
        return User::create(array_merge([
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'firstName' => 'Test',
            'middleName' => 'User',
            'lastName' => 'Sample',
            'contactNumber' => '09123456789',
            'birthday' => '1990-01-01',
            'proofOfIdentity' => 'test-id.png',
            'role' => 'resident',
            'status' => 'approved',
            'registrationDate' => now(),
        ], $overrides));
    }

    private function createResident(User $user, array $overrides = []): Resident
    {
        return Resident::create(array_merge([
            'firstName' => $user->firstName,
            'middleName' => $user->middleName,
            'lastName' => $user->lastName,
            'contactNo' => '09123456789',
            'birthday' => '1990-01-01',
            'emergencyContactNo' => '09987654321',
            'emergencyContactName' => 'Emergency Contact',
            'age' => 35,
            'sex' => 'male',
            'parent' => 'yes',
            'enrolled' => 'no',
            'educationalAttainment' => 'College',
            'religion' => 'Catholic',
            'headOfFamily' => 'no',
            'EncodedBy' => $user->id,
            'user_id' => $user->id,
        ], $overrides));
    }
}