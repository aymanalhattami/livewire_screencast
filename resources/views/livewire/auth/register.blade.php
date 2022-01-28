<form action="" wire:submit.prevent='register'>
    <div>
        <label for="email">Email</label>
        <input wire:model="email" type="email" name="email" id="email">
        @error('email') <span> {{ $message }} </span> @enderror
    </div>
    <div>
        <label for="password">password</label>
        <input wire:model="password" type="password" name="password" id="password">
        @error('password') <span> {{ $message }} </span> @enderror
    </div>
    <div>
        <label for="passwordConfirmation">passwordConfirmation</label>
        <input wire:model="passwordConfirmation" type="password" name="passwordConfirmation" id="passwordConfirmation">
    </div>

    <div>
        <input type="submit" value="Register">
    </div>
</form>