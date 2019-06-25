<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-orange-400 pl-4">
        Invite a user
    </h3>
            
        <form action="{{ action('ProjectInvitationsController@store', $project) }}" method="post" class="pb-3">
            @csrf
            <div class="mb-4">
                <input type="email" name="email"
                    class="bg-transparent border border-rtgray rounded w-full py-2 px-3"
                    placeholder="E-mail address...">
            </div>
            <div class="flex justify-center">
                <button type="submit" class="text-normal button">Invite</button>
            </div>

            @include('_errors', ['bag' => 'invitations'])

        </form>

</div>