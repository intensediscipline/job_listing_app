<x-layout>
  <h1>Available Jobs</h1>
  <ul>
    @forelse ($jobs as $job )
      @if($job == 'Database Admin')
        @continue
        @endif
      <li>{{ $job }}</li>
      @empty
      <li>No jobs available</li>
    @endforelse
  </ul>
</x-layout>