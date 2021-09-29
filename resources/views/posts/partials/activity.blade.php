<div class="container">
    <div class="row">
        <x-card title="Most Commented" subtitle="What people are currently talking about" :items="$mostCommented" />
    </div>
    <div class="row mt-4">
        <x-card title="Most Active" subtitle="Writers with most posts written" :items="collect($mostActive)->pluck('name')" />
    </div>

    <div class="row mt-4">
        <x-card title="Most Active Last Month" subtitle="Users with most posts written in the month" :items="collect($mostActiveLastMonth)->pluck('name')" />
    </div>
</div>