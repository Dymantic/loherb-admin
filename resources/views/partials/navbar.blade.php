<div class="h-12 bg-black w-full flex justify-between items-center px-4 shadow">
    <div>
        <a href="/admin" class="text-2xl antialiased text-white no-underline">
            <span class="font-light">Loherb</span>
        </a>
    </div>
    <div class="flex items-center justify-end">
        <a href="/users" class="text-white no-underline mr-4">Users</a>
        <dropdown-item v-cloak name="{{ Auth()->user()->email }}" class="text-white h-12 flex items-center">
            <div slot="dropdown_content" class="pt-3">
                <a href="reset-password" class="text-grey-darker no-underline hover:text-green">Reset Password</a>
                @include('partials.logout-form')
            </div>
        </dropdown-item>
    </div>
</div>