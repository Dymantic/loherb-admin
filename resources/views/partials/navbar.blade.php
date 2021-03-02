<div class="h-16 bg-black w-full flex justify-between items-center shadow">
    <div class="pl-4">
        <a href="/" class="text-2xl antialiased text-white hover:text-gold no-underline">
            @include('svg.leaf-plain', ['classes' => 'h-4'])
            <span class="font-semibold">Loherb</span>
        </a>
    </div>
    <div class="flex items-center justify-end">
        <dropdown-item v-cloak name="Blog" class="text-white h-16 flex items-center mr-4">
            <div slot="dropdown_content" class="pt-3">
                <a href="/blog" class="text-grey-darker no-underline hover:text-green block mb-3">Posts</a>
                <a href="/categories" class="text-grey-darker no-underline hover:text-green block ">Categories</a>
            </div>
        </dropdown-item>
        <a href="/users" class="text-white no-underline mr-4">Users</a>
        <dropdown-item v-cloak name="{{ Auth()->user()->email }}" class="text-white h-16 flex items-center bg-grey-darkest px-4">
            <div slot="dropdown_content" class="pt-3">
                <a href="/reset-password" class="text-grey-darker no-underline hover:text-green">Reset Password</a>
                @include('partials.logout-form')
            </div>
        </dropdown-item>
    </div>
</div>
