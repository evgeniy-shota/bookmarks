<x-layout>
    <x-slot:main>
        <x-flex-container class="sm:w-1/2">
            <div class="text-lg font-bold">Reset password</div>
            <form action="{{ route('password.update') }}" method="post">
                @csrf
                <x-html.formcontrols.fieldset title="New Password">
                    <x-slot:field>
                        <x-html.formcontrols.input required id="password"
                            type="password" />
                    </x-slot:field>
                    <x-slot:legend>
                        @error('password')
                            <div class="text-rose-300">
                                {{ $message }}
                            </div>
                        @enderror
                        <div>
                            Enter a new password, it must contain at least 8
                            characters, including at least one number, letter
                            and symbol
                        </div>

                    </x-slot:legend>
                </x-html.formcontrols.fieldset>

                <x-html.formcontrols.fieldset title="Confirm Password">
                    <x-slot:field>
                        <x-html.formcontrols.input required
                            id="password_confirmation" type="password" />
                    </x-slot:field>
                    <x-slot:legend>
                        @error('password_confirmation')
                            <div class="text-rose-300">
                                {{ $message }}
                            </div>
                        @enderror
                        <div>
                            Enter the same password
                        </div>

                    </x-slot:legend>
                </x-html.formcontrols.fieldset>

                <div class="flex justify-center">
                    <x-html.button-out-green type="submit" class="w-1/3">
                        Save
                    </x-html.button-out-green>
                </div>

                <x-html.formcontrols.input id="email" hidden readonly
                    :value="$email" />

                <x-html.formcontrols.input id="token" hidden readonly
                    :value="$token" />

            </form>
        </x-flex-container>
    </x-slot:main>
</x-layout>
