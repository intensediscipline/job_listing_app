<x-layout>
  <x-slot name="title">Create Job</x-slot>
  <h1>Create New Job1</h1>
  <form action="/jobs" method="post">
    @csrf
    <input type="text" name="title" placeholder="title" id="">
    <input type="text" name="description" placeholder="description" id="">
    <input type="submit" value="Submit">
  </form>
</x-layout>