<form class="search-containers search" method="POST" action="/coordinator">
    <input name="_method" value="PATCH" hidden />
    <input type="hidden" name="schoolSearchValue" id="schoolSearchValue" />
    <input type="text" name="search" id="search" placeholder="Search School" value="<?= htmlspecialchars($search ?? '') ?>" onkeyup="showDropdown()" />
    <button type="submit" class="search" onclick="handleSubmit(event)">
        <i class="bi bi-search"></i>
    </button>

    <div class="dropdown-menu mt-5" id="dropdownMenu" aria-labelledby="dropdownMenuButton" style="display: none;">
        <!-- Dropdown content will be populated here by AJAX -->
    </div>
</form>

<script>
// Store the list of schools globally
var schoolList = [];

function showDropdown() {
    var input = document.getElementById("search").value;
    var dropdown = document.getElementById("dropdownMenu");

    // Show dropdown when input has value, hide when empty
    if (input.length > 0) {
        performSearch();  // Call the function to update dropdown content
    } else {
        dropdown.style.display = "none";
    }
}

function performSearch() {
    var input = document.getElementById("search").value;
    var dropdown = document.getElementById("dropdownMenu");

    dropdown.style.width = input.offsetWidth + "px";

    if (input.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/coordinator/searchinfo", true); // Update with your PHP endpoint
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                dropdown.innerHTML = ""; // Clear existing dropdown items

                // Clear the schoolList array
                schoolList = [];

                // Check if the response is empty
                if (response.length === 0) {
                    var noResultItem = document.createElement("li");
                    noResultItem.textContent = "No results found"; // Message for no results
                    noResultItem.style.pointerEvents = "none"; // Disable pointer events
                    dropdown.appendChild(noResultItem); // Append the item to the dropdown

                    // Show the dropdown
                    dropdown.style.display = "block";
                } else {
                    // Populate dropdown with the response data
                    response.forEach(function(school) {
                        var li = document.createElement("li");
                        li.setAttribute("data-value", school.school_name);
                        li.textContent = school.school_name;
                        li.style.cursor = "pointer";
                        li.onclick = function() {
                            document.getElementById("search").value = school.school_name; // Set input value
                            document.getElementById("schoolSearchValue").value = school.school_name; // Set the hidden input value
                            var form = document.querySelector('.search-containers.search');  // Explicitly selecting the form
                            form.submit();
                            dropdown.style.display = "none"; // Hide the dropdown
                        };
                        dropdown.appendChild(li);

                        // Store the school name in the schoolList
                        schoolList.push(school.school_name);
                    });

                    // Show the dropdown
                    dropdown.style.display = "block"; 
                }
            } else {
                console.error('Error fetching data:', xhr.statusText); 
            }
        };

        xhr.send("search=" + encodeURIComponent(input));
    } else {
        dropdown.style.display = "none"; 
    }
}

// Function to handle the form submission, either through button or manual input
function handleSubmit(event) {
    event.preventDefault(); // Prevent default form submission for now

    var input = document.getElementById("search").value;
    var hiddenInput = document.getElementById("schoolSearchValue");

    // Check if the manually entered value matches any school name in the list
    if (schoolList.includes(input)) {
        hiddenInput.value = input; // If it matches, set the hidden input value
    } else {
        hiddenInput.value = ""; // Otherwise, clear the hidden input value (or keep it as is)
    }

    // Now, submit the form programmatically
    document.querySelector('.search-containers.search').submit();
}
</script>
