
public function test_user_cannot_vote_twice_in_same_battle()
{
    $user = User::factory()->create();
    $battle = Battle::factory()->create(['deadline' => now()->addDay()]);
    $m1 = Meme::factory()->create(['battle_id' => $battle->id]);
    $m2 = Meme::factory()->create(['battle_id' => $battle->id]);

    $this->actingAs($user)->post(route('memes.vote', $m1));
    $this->actingAs($user)->post(route('memes.vote', $m2))
         ->assertSessionHas('error');
}
