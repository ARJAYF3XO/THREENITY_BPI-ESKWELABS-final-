<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulation Step 1 - Personal Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-custom-primary text-custom-primary d-flex flex-column min-vh-100">

<?php include '../navbar.php'; ?>

<div class="container py-5 flex-grow-1">
    <div class="card card-custom p-4 card-border-primary">
        <div class="mb-4">
            <!-- ✅ Step Navigation -->
                <div class="stepper mb-4 text-center">
                <div class="step active step-link-1" data-target="sim1_view.php">
                    <div class="circle">1</div>
                    <div class="label">Profile</div>
                </div>
                <div class="line"></div>
                <div class="step step-link-2" data-target="sim2_view.php">
                    <div class="circle">2</div>
                    <div class="label">Simulation</div>
                </div>
                <div class="line"></div>    
                <div class="step step-link-3" data-target="sim1_view.php">
                    <div class="circle">3</div>
                    <div class="label">Results</div>
                </div>
            </div>
        </div>

        <h2 class="mb-4 text-center">Personal Information Form</h2>
        <form id="personalInfoForm" action="sim1_logic.php" method="POST">
            
            <!-- Personal Information -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="col-md-6">
                    <label for="sex" class="form-label">Sex</label>
                    <select class="form-select" id="sex" name="sex" required>
                        <option value="" disabled>Select your sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="e.g., Philippines" required>
                </div>
                <div class="col-md-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                </div>
                <div class="col-md-6">
                    <label for="occupancy" class="form-label">Occupancy</label>
                    <input type="text" class="form-control" id="occupancy" name="occupancy" placeholder="e.g., Employed, Self-employed" required>
                </div>
                <div class="col-md-6">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" name="position" placeholder="e.g., Software Engineer, Teacher" required>
                </div>
                <div class="col-12">
                    <label for="religion" class="form-label">Religion (Optional)</label>
                    <input type="text" class="form-control" id="religion" name="religion" placeholder="e.g., Christianity, Islam">
                </div>
            </div>

            <hr class="my-4">

            <!-- Financial Information -->
            <h3 class="mb-3">Financial Information</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="salary" class="form-label">Salary/Income (Monthly)</label>
                    <input type="number" class="form-control" id="salary" name="salary" min="0" placeholder="e.g., 50000" required>
                </div>
                <div class="col-md-6">
                    <label for="monthlyExpense" class="form-label">Monthly Expense</label>
                    <input type="number" class="form-control" id="monthlyExpense" name="monthlyExpense" min="0" placeholder="e.g., 25000" required>
                </div>
                <div class="col-md-6">
                    <label for="savings" class="form-label">Current Savings</label>
                    <input type="number" class="form-control" id="savings" name="savings" placeholder="e.g., 100000">
                </div>
            </div>

            <hr class="my-4">

            <!-- Education -->
            <h3 class="mb-3">Education</h3>
            <div class="row g-3 align-items-end mb-3">
                <div class="col-md-4">
                    <label for="educationDegree" class="form-label">Degree</label>
                    <input type="text" class="form-control" id="educationDegree" placeholder="e.g., Bachelor of Science">
                </div>
                <div class="col-md-5">
                    <label for="educationCollege" class="form-label">College/University</label>
                    <input type="text" class="form-control" id="educationCollege" placeholder="e.g., University of the Philippines">
                </div>
                <div class="col-md-2">
                    <label for="educationYear" class="form-label">Year</label>
                    <input type="number" class="form-control" id="educationYear" min="1900" max="2100" placeholder="e.g., 2018">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-custom-primary w-100" id="addEducationBtn">
                        <i class="bi bi-plus-lg"> Add</i>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <h4>Current Education</h4>
                <ul class="list-group" id="educationList"></ul>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg">Save and Continue</button>
            </div>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addEducationBtn = document.getElementById('addEducationBtn');
    const educationList = document.getElementById('educationList');
    const educationDegreeInput = document.getElementById('educationDegree');
    const educationCollegeInput = document.getElementById('educationCollege');
    const educationYearInput = document.getElementById('educationYear');
    const form = document.getElementById('personalInfoForm');

    const nameInput = document.getElementById('name');
    const sexInput = document.getElementById('sex');
    const countryInput = document.getElementById('country');
    const dobInput = document.getElementById('dob');
    const occupancyInput = document.getElementById('occupancy');
    const positionInput = document.getElementById('position');
    const religionInput = document.getElementById('religion');
    const salaryInput = document.getElementById('salary');
    const monthlyExpenseInput = document.getElementById('monthlyExpense');
    const savingsInput = document.getElementById('savings');

    let educationEntries = []; 
    let editingIndex = -1; 

    function clearEducationInputs() {
        educationDegreeInput.value = '';
        educationCollegeInput.value = '';
        educationYearInput.value = '';
    }

    function resetButtonToAdd() {
        addEducationBtn.innerHTML = '<i class="bi bi-plus-lg"></i> Add';
        addEducationBtn.classList.remove('btn-warning');
        addEducationBtn.classList.add('btn-primary');
        editingIndex = -1; 
    }

    function renderEducationList() {
        educationList.innerHTML = ''; 
        educationEntries.forEach((entry, index) => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item d-flex justify-content-between align-items-center card-feature mb-2';
            listItem.innerHTML = `
                <div>
                    <strong>${entry.degree}</strong> from ${entry.college} (${entry.year})
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-info text-white me-2 edit-btn" data-index="${index}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-index="${index}">
                        <i class="bi bi-trash"></i> Trash
                    </button>
                </div>
                <input type="hidden" name="education[${index}][degree]" value="${entry.degree}">
                <input type="hidden" name="education[${index}][college]" value="${entry.college}">
                <input type="hidden" name="education[${index}][year]" value="${entry.year}">
            `;
            educationList.appendChild(listItem);
        });
    }

    addEducationBtn.addEventListener('click', function () {
        const degree = educationDegreeInput.value.trim();
        const college = educationCollegeInput.value.trim();
        const year = educationYearInput.value.trim();

        if (degree && college && year) {
            if (editingIndex === -1) {
                educationEntries.push({ degree, college, year });
            } else {
                educationEntries[editingIndex] = { degree, college, year };
                resetButtonToAdd(); 
            }
            renderEducationList();
            clearEducationInputs();
        } else {
            console.log('Please fill in all education fields before adding or updating.');
        }
    });

    educationList.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-btn') || event.target.closest('.delete-btn')) {
            const button = event.target.classList.contains('delete-btn') ? event.target : event.target.closest('.delete-btn');
            const index = parseInt(button.dataset.index);
            educationEntries.splice(index, 1);
            renderEducationList();
            if (editingIndex === index) { 
                resetButtonToAdd();
                clearEducationInputs();
            } else if (editingIndex > index) { 
                editingIndex--;
            }
        }
        else if (event.target.classList.contains('edit-btn') || event.target.closest('.edit-btn')) {
            const button = event.target.classList.contains('edit-btn') ? event.target : event.target.closest('.edit-btn');
            const index = parseInt(button.dataset.index);

            editingIndex = index;

            const entryToEdit = educationEntries[index];

            educationDegreeInput.value = entryToEdit.degree;
            educationCollegeInput.value = entryToEdit.college;
            educationYearInput.value = entryToEdit.year;

            addEducationBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Update';
            addEducationBtn.classList.remove('btn-primary');
            addEducationBtn.classList.add('btn-warning');

            educationDegreeInput.focus();
        }
    });

    // ⚠️ Stepper Navigation with warning instead of autosave
    document.querySelectorAll(".step-link-2").forEach(link => {
        link.addEventListener("click", function (e) {
            const target = this.getAttribute("data-target");
            if (this.classList.contains("active")) return;

            const confirmLeave = alert("save and continue your progress to proceed");
            if (confirmLeave) {
                window.location.href = target;
            } else {
                e.preventDefault();
            }
        });
    });

     document.querySelectorAll(".step-link-3").forEach(link => {
        link.addEventListener("click", function (e) {
            const target = this.getAttribute("data-target");
            if (this.classList.contains("active")) return;

            const confirmLeave = alert("cannot proceed to results");
            if (confirmLeave) {
                window.location.href = target;
            } else {
                e.preventDefault();
            }
        });
    });
    // ✅ Autofill existing profile
    fetch('get_user_profile.php')
        .then(response => response.json())
        .then(data => {
            if (data.profile) {
                nameInput.value = data.profile.name || '';
                const sexValue = (data.profile.sex || data.profile.gender || '').toLowerCase();
                if (sexValue === 'male') sexInput.value = 'Male';
                else if (sexValue === 'female') sexInput.value = 'Female';
                else if (sexValue === 'other') sexInput.value = 'Other';

                countryInput.value = data.profile.country || '';
                dobInput.value = data.profile.dob || '';
                occupancyInput.value = data.profile.occupancy || '';
                positionInput.value = data.profile.position || '';
                religionInput.value = data.profile.religion || '';
                salaryInput.value = data.profile.salary || '';
                monthlyExpenseInput.value = data.profile.monthly_expense || '';
                savingsInput.value = data.profile.savings || '';

                if (Array.isArray(data.education)) {
                    educationEntries = data.education.map(e => ({
                        degree: e.degree,
                        college: e.college,
                        year: e.year
                    }));
                    renderEducationList();
                }
            }
        })
        .catch(err => {
            console.error('Error fetching profile:', err);
        });
});
</script>
</body>
</html>
