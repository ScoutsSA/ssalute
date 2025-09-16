<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Scouts South Africa</h1>

    <p class="text-gray-600 mb-6">
        Have you already got an account on scouts digital?
    </p>
    <div>
        <form wire:submit="checkEmail">
            <label>
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 text-sm font-bold mb-2">Email:</label>
                    <input wire:model="email"  type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 transition duration-300">
                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </label>

            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Check</button>
            @error('submit') <span class="text-red-500">{{ $message }}</span> @enderror
            @if ($exists === true)
                <div class="mx-auto text-center">
                    <p class="text-green-500 my-4">
                        This account already exists on Scouts Digital!
                    </p>
                    <a href="https://ssa.scouts.digital/login" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                        Login to Scouts Digital <x-filament::icon icon="heroicon-s-arrow-top-right-on-square" class="w-6 h-6 inline-block" />
                    </a>
                </div>
            @elseif ($exists === false)
                <div class="mx-auto text-center">
                    <p class="text-red-500  mt-4">
                        You don't have an account!
                    </p>
                    <p class="text-gray-600 mb-6">
                        Would you like to join as an Adult Member?
                    </p>
                    <a href="{{ route('forms.register.adult.aam', ['email' => $email]) }}" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                        Apply as Adult Member
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
