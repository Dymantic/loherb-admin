<div class="h-12 bg-black w-full flex justify-between items-center px-4 shadow">
    <div>
        <a href="/" class="text-2xl antialiased text-white no-underline">
            <span class="font-light">Loherb</span>
        </a>
    </div>
    <div class="flex items-center justify-end">
        <dropdown-item v-cloak name="Blog" class="text-white h-12 flex items-center mr-4">
            <div slot="dropdown_content" class="pt-3">
                <a href="/blog" class="text-grey-darker no-underline hover:text-green block mb-3">Posts</a>
                <a href="/categories" class="text-grey-darker no-underline hover:text-green block ">Categories</a>
            </div>
        </dropdown-item>
        <a href="/users" class="text-white no-underline mr-4">Users</a>
        <dropdown-item v-cloak name="{{ Auth()->user()->email }}" class="text-white h-12 flex items-center">
            <div slot="dropdown_content" class="pt-3">
                <a href="/reset-password" class="text-grey-darker no-underline hover:text-green">Reset Password</a>
                @include('partials.logout-form')
            </div>
        </dropdown-item>
    </div>
</div>
