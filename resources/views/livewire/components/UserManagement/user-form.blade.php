 <!-- Edit user modal -->
 <div id="UserModal" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <div class="relative w-full max-w-2xl max-h-full">
         <!-- Modal content -->
         <form class="relative bg-[rgb(238,238,238)] rounded-lg shadow ">
             <!-- Modal header -->
             <div class="flex items-center justify-between px-6 py-2 border-b rounded-t ">
                 <div class="flex justify-center w-full p-2">
                     <h3 class="text-xl font-black text-gray-900 item ">
                         Create User
                     </h3>
                 </div>
                 <button type="button"
                     class="absolute right-[26px] inline-flex items-center justify-center w-8 h-8 text-sm text-[rgb(53,53,53)] bg-transparent rounded-lg hover:bg-[rgb(52,52,52)] transition duration-100 ease-in-out hover:text-gray-100 ms-auto "
                     data-modal-hide="UserModal">
                     <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 14">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                     </svg>
                     <span class="sr-only">Close modal</span>
                 </button>
             </div>
             <!-- Modal body -->
             <div class="p-6 space-y-6">
                 <form class="flex flex-col max-w-sm mx-auto">
                     <div class="flex flex-col gap-4">
                         {{-- PERSONAL INFORMATION SECTION --}}
                         <div class="border-2 border-[rgb(53,53,53)] rounded-md">
                             <div
                                 class="p-2 border-b bg-[rgb(53,53,53)] text-[rgb(242,242,242)] pointer-events-none rounded-br-sm rounded-bl-sm">
                                 <h1 class="font-bold">Personal Information</h1>
                             </div>
                             <div class="p-4">
                                 <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">
                                     <div class="mb-3">
                                         <label for="firstname"
                                             class="block mb-2 text-sm font-medium text-gray-900 ">First
                                             Name</label>
                                         <input type="text" id="firstname"
                                             class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                             placeholder="First Name" tabindex="2" required />
                                     </div>
                                     <div class="mb-3">
                                         <label for="middlename"
                                             class="block mb-2 text-sm font-medium text-gray-900 ">Middle
                                             Name <span class="text-red-400 ">*</span></label>
                                         <input type="text" id="middlename"
                                             class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                             placeholder="Middle Name" required />
                                     </div>
                                 </div>
                                 <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">
                                     <div class="mb-3">
                                         <label for="lastname"
                                             class="block mb-2 text-sm font-medium text-gray-900 ">Last
                                             Name</label>
                                         <input type="text" id="lastname"
                                             class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                             placeholder="Last Name" required />
                                     </div>
                                     <div class="mb-3">
                                         <label for="contactno"
                                             class="block mb-2 text-sm font-medium text-gray-900 ">Contact
                                             No</label>
                                         <input type="text" id="password"
                                             class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                             placeholder="Contact No" required />
                                     </div>
                                 </div>
                                 <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">
                                     <div class="mb-3">
                                         <label for="countries"
                                             class="block mb-2 text-sm font-medium text-gray-900 ">Select
                                             an option</label>
                                         <select id="user_roles"
                                             class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                                             <option selected>Select a role</option>
                                             <option value="CA">Cashier</option>
                                             <option value="AD">Admin</option>
                                             <option value="IS">Inventory Staff</option>
                                         </select>
                                     </div>
                                     <div class="mb-3">
                                         <label for="countries"
                                             class="block mb-2 text-sm font-medium text-gray-900 ">Status</label>
                                         <select id="status"
                                             class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                                             <option selected>Set your status</option>
                                             <option value="AC">Active</option>
                                             <option value="INAC">Inactive</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         {{-- LOGIN INFORMATION SECTION --}}
                         <div class="border-2 border-[rgb(53,53,53)] rounded-md">
                             <div
                                 class="p-2 border-b  bg-[rgb(53,53,53)] text-[rgb(242,242,242)] pointer-events-none rounded-br-sm rounded-bl-sm">
                                 <h1 class="font-bold">Login Information</h1>
                             </div>
                             <div class="p-4">
                                 <div class="mb-3">
                                     <label for="username"
                                         class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                                     <input type="text" id="username"
                                         class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                         placeholder="Username" required />
                                 </div>
                                 <div class="mb-3">
                                     <label for="password"
                                         class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                                     <input type="password" id="password"
                                         class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                         required />
                                 </div>
                                 <div class="mb-3">
                                     <label for="retypepassword"
                                         class="block mb-2 text-sm font-medium text-gray-900">Re-type
                                         Password</label>
                                     <input type="password" id="retypepassword"
                                         class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                         required />
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- Modal footer -->
                     <div class="flex flex-row justify-end gap-2">
                         <div>
                             <button
                                 class="text-[rgb(53,53,53)] hover:bg-gray-100 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Clear
                                 All</button>
                         </div>
                         <div>
                             <button type="submit"
                                 class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
                         </div>
                     </div>
                 </form>

             </div>

         </form>
     </div>
 </div>
