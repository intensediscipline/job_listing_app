<x-layout>
  <section class="flex flex-col md:flex-row gap-4">
    {{-- profile form --}}
  <div class="bg-white p-8 rounded-lg shadow-md w-full">
      <h3 class="text-3xl text-center font-bold mb-4">
        Profile Info
      </h3>
      @if($user->profile_image) 
        <div class="mt-2 flex justify-center">
          <img class="w-32 h-32 object-cover rounded-full" src="{{asset('storage/' . $user->profile_image)}}" alt="{{$user->name}}" />
        </div>
      @endif
      <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-inputs.text id="name" name="name" label="Name" value="{{$user->name}}"/>
        <x-inputs.text id="email" name="email" label="Email Address" type="email" value="{{$user->email}}" />
        <x-inputs.file id="profile_image" name="profile_image" />

        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 border-rounded focus:outline:none">Save</button>
      </form>
  </div>
    {{--job listings--}}
  <div class="bg-white p-8 rounded-lg shadow-md w-full">
    <h3 class="text-3xl text-center font-bold mb-4">
      My Job Listings
    </h3>
    @forelse ($jobs as $job)
      <div class="flex justify-between items-center border-b-2 border-gray-200 py-2">
        <div>
          <h3 class="text-xl font-semibold">{{ $job->title }}</h3>
          <p class="text-gray-700">{{ $job->job_type }}</p>
        </div>
        <div class="flex space-x-3">
          <a href="{{route('jobs.edit', $job->id)}}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Edit</a>
        
          <!-- Delete Form -->
          <form method="POST" action="{{route('jobs.destroy', $job->id)}}?from=dashboard" onsubmit="return confirm('Are you sure you want to delete this job?')">
            @csrf
            @method('DELETE')
              <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm">
                  Delete
              </button>
          </form>
          <!-- End Delete Form -->
        </div>
      </div>
      {{-- applicants --}}
      <div class="mt-4 bg-amber-50 p-2">
        <h4 class="text-lg font-semibold mb-2">Applicants</h4>
        @forelse($job->applicants as $applicant)
          <div class="py-2">
            <p class="text-gray-800">
              <strong>Name: </strong> {{ $applicant->full_name }}
            </p>
            <p class="text-gray-800">
              <strong>Phone: </strong> {{ $applicant->contact_phone }}
            </p>
            <p class="text-gray-800">
              <strong>Email: </strong> {{ $applicant->contact_email }}
            </p>
            <p class="text-gray-800">
              <strong>Message: </strong> {{ $applicant->message }}
            </p>
            <p class="text-gray-800 mt-2">
              <a href="{{asset('storage/' . $applicant->cv_path)}}" class="text-blue-500 hover:underline text-sm" download>
                <i class="fas fa-download"></i> Download CV
              </a>
            </p>
            {{-- delete applicant --}}
            <form action="{{route('applicant.destroy', $applicant->id)}}" method="post" onsubmit="return confirm('Are you sure you want to delete this applicant?')">
              @csrf
              @method('DELETE')
              <button class="text-red-500 hover:text-red-700 text-sm" type="aubmit"><i class="fas fa-trash"></i> Delete Applicant</button>
            </form>
          </div>
        @empty
          <p class="gray-700 mb-5">There are no applicants for this job</p>
        @endforelse
      </div>
    @empty
      <p class="text-gray-700">You have no job listings</p>
    @endforelse
  </div>
</section>
<x-bottom-banner></x-bottom-banner>
</x-layout>