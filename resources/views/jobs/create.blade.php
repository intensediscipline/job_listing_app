<x-layout>
  <x-slot name="title">Create Job</x-slot>
  <div class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl">
    <h2 class="text-4xl text-center font-bold mb-4">
        Create Job Listing
    </h2>
    <form
        method="POST"
        action="/jobs"
        enctype="multipart/form-data"
    >
    @csrf
        <h2
            class="text-2xl font-bold mb-6 text-center text-gray-500"
        >
            Job Info
        </h2>

        <x-inputs.text id="title" name="title" label="Job Title" placeholder="Software Engineer" />

        <x-inputs.text-area id="description" name="description" label="Job Description" placeholder="We are seeking a skilled and motivated Software Developer to join our growing development team..." />        

        <x-inputs.text id="salary" name="salary" label="Annual salary" type="number" placeholder="90000" />

        <x-inputs.text-area id="requirements" name="requirements" label="Requirements" placeholder="Bachelor's degree in Computer Science" />        

        <x-inputs.text-area id="benefits" name="benefits" label="Benefits" placeholder="Bachelor's degree in Computer Science" />  

        <x-inputs.text id="tags" name="tags" label="Tags (comma-separated)" placeholder="Health insurance, 401k, paid time off" />

        <x-inputs.select id="job_type" name="job_type" label="Job Type" value="{{old('job_type')}}" :options="['Full-Time' => 'Full-Time', 'Part-Time' => 'Part-Time', 'Contract' => 'Contract', 'Temporary' => 'Temporary', 'Internship' => 'Internship', 'Volunteer' => 'Volunteer', 'On-Call' => 'On-Call']" />

        <x-inputs.select id="remote" name="remote" label="Remote" value="{{old('remote')}}" :options="[0 => 'No', 1 => 'Yes']" />

        <x-inputs.text id="address" name="address" label="Address" placeholder="123 Main St" />

        <x-inputs.text id="city" name="city" label="City" placeholder="Albany" />

        <x-inputs.text id="state" name="state" label="State" placeholder="NY" />

        <x-inputs.text id="zipcode" name="zipcode" label="Zip Code" placeholder="12201" />

        <h2
            class="text-2xl font-bold mb-6 text-center text-gray-500"
        >
            Company Info
        </h2>

        <x-inputs.text id="company_name" name="company_name" label="Company Name" placeholder="Company Name" />

        <x-inputs.text-area id="company_description" name="company_description" label="Company Description" placeholder="Company Description" /> 

        <x-inputs.text id="company_website" name="company_website" type="url" label="Company Website" placeholder="Enter website" />

        <x-inputs.text id="contact_phone" name="contact_phone" label="Contact Phone" placeholder="Enter phone" />

        <x-inputs.text id="contact_email" name="contact_email" label="Contact Email" placeholder="Email where you want to receive applications" />

        <x-inputs.file id="company_logo" name="company_logo" label="Company Logo" />

        <button
            type="submit"
            class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
        >
            Save
        </button>
    </form>
</div>
</x-layout>