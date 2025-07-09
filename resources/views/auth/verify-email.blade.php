<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                    Verify your email
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                </p>
            </div>

            <div class="space-y-4">
                @if (session('status') == 'verification-link-sent')
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                <div class="flex items-center justify-between space-x-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Resend Verification Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white underline">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>