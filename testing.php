<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI FINas</title>
    <!-- Use Tailwind CSS for a clean, responsive design -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Use Inter font family for better readability -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <!-- Main container for the agentic UI -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full max-w-2xl flex flex-col h-[80vh] md:h-[90vh]">
        
        <!-- Header -->
        <header class="bg-blue-600 text-white p-4 flex items-center justify-center rounded-t-2xl shadow-md">
            <h1 class="text-2xl font-bold">AI FINas</h1>
        </header>

        <!-- Main content area where prompts, forms, and results are displayed -->
        <div id="main-content" class="flex-1 p-6 flex flex-col items-center justify-center text-center">
            <div class="bg-gray-200 text-gray-800 p-6 rounded-2xl max-w-[80%] shadow-lg">
                <p class="text-lg font-semibold">I'm your Financial Intelligent Adviser.</p>
                <p class="mt-2 text-md text-gray-600">State a financial goal below to begin a personalized simulation.</p>
            </div>
        </div>

        <!-- Input area for user goals -->
        <div class="p-4 bg-gray-100 border-t border-gray-200 flex items-center gap-2">
            <textarea
                id="user-input"
                class="flex-1 p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none overflow-hidden"
                rows="1"
                placeholder="Type your financial goal (e.g., 'I want to make a retirement fund')..."
                oninput="resizeTextarea(this)"
            ></textarea>
            <button
                id="send-button"
                class="bg-blue-600 text-white p-3 rounded-full hover:bg-blue-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed shadow-md"
            >
                <!-- SVG icon for send button -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send"><path d="m22 2-7 20-4-9-9-4 20-7z"/><path d="M22 2 11 13"/></svg>
            </button>
        </div>
    </div>

    <script>
        // DOM element references
        const mainContent = document.getElementById('main-content');
        const userInput = document.getElementById('user-input');
        const sendButton = document.getElementById('send-button');

        // Function to dynamically resize the textarea based on content
        function resizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        // Function to render content dynamically in the main area
        function renderContent(htmlString) {
            mainContent.innerHTML = ''; // Clear existing content
            mainContent.innerHTML = htmlString;
        }

        // Function to handle form submission
        function handleFormSubmit(event) {
            event.preventDefault();
            
            // Get form data from the dynamically created form
            const form = event.target;
            const age = form.age.value;
            const retirementAge = form.retirementAge.value;
            const currentSavings = form.currentSavings.value;
            const monthlyContribution = form.monthlyContribution.value;

            // Show a loading state
            renderContent(`
                <div class="flex flex-col items-center justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                    <p class="mt-4 text-gray-600">Simulating your financial future...</p>
                </div>
            `);

            // Simulate AI processing and response
            setTimeout(() => {
                const yearsToRetirement = retirementAge - age;
                const finalAmount = parseInt(currentSavings) + (parseInt(monthlyContribution) * 12 * yearsToRetirement);

                const resultHtml = `
                    <div class="bg-white p-6 rounded-2xl shadow-lg w-full">
                        <h3 class="text-2xl font-bold text-blue-600">Simulation Complete</h3>
                        <div class="mt-4 text-left space-y-3">
                            <p class="text-gray-700">Based on your input, here is a preliminary simulation of your retirement plan:</p>
                            <p class="text-lg">
                                With a monthly contribution of <strong>₱${monthlyContribution}</strong>, you are projected to have a retirement fund of approximately
                                <span class="block text-4xl font-extrabold text-blue-800 my-2">₱${finalAmount.toLocaleString('en-PH')}</span>
                                by the age of ${retirementAge}.
                            </p>
                            <p class="text-sm text-gray-500 italic mt-4">
                                This simulation provides a high-level estimate and does not account for inflation, investment growth, or taxes. For professional advice, consult a financial advisor.
                            </p>
                        </div>
                    </div>
                `;
                renderContent(resultHtml);
                
                // Re-enable the input field for the next goal
                userInput.disabled = false;
                userInput.placeholder = "Enter a new financial goal...";
                userInput.focus();
            }, 2000);
        }

        // Function to handle user goals
        function handleSendMessage() {
            const goal = userInput.value.trim();
            if (goal === '') {
                return; // Do nothing if the input is empty
            }

            userInput.disabled = true; // Disable input while processing
            userInput.value = ''; // Clear the input field
            resizeTextarea(userInput);

            // Show a loading state
            renderContent(`
                <div class="flex flex-col items-center justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                    <p class="mt-4 text-gray-600">Preparing your personalized simulation...</p>
                </div>
            `);

            // Simulate AI response based on the user's goal
            setTimeout(() => {
                if (goal.toLowerCase().includes('retirement fund')) {
                    const formHtml = `
                        <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md">
                            <h3 class="text-xl font-bold text-blue-600 mb-4">Retirement Fund Details</h3>
                            <p class="text-gray-700 mb-4">Please provide some details to simulate your retirement plan:</p>
                            <form id="retirement-form" class="space-y-4">
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-1" for="age">Current Age</label>
                                    <input type="number" id="age" name="age" class="p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 30" required>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-1" for="retirementAge">Desired Retirement Age</label>
                                    <input type="number" id="retirementAge" name="retirementAge" class="p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 65" required>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-1" for="currentSavings">Current Savings (in ₱)</label>
                                    <input type="number" id="currentSavings" name="currentSavings" class="p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 50000" required>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-1" for="monthlyContribution">Monthly Contribution (in ₱)</label>
                                    <input type="number" id="monthlyContribution" name="monthlyContribution" class="p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 2000" required>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white p-3 mt-4 rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                                    Simulate
                                </button>
                            </form>
                        </div>
                    `;
                    renderContent(formHtml);
                    
                    // Attach the event listener to the dynamically created form
                    document.getElementById('retirement-form').addEventListener('submit', handleFormSubmit);
                } else {
                    const errorHtml = `
                        <div class="bg-red-100 p-6 rounded-2xl shadow-lg w-full max-w-md">
                            <h3 class="text-xl font-bold text-red-700 mb-2">Goal Not Supported</h3>
                            <p class="text-gray-700">I'm currently only configured to assist with retirement fund simulations. Please try asking about that instead!</p>
                        </div>
                    `;
                    renderContent(errorHtml);
                    userInput.disabled = false;
                    userInput.placeholder = "Enter a new financial goal...";
                    userInput.focus();
                }
            }, 2000);
        }

        // Event listener for the send button click
        sendButton.addEventListener('click', handleSendMessage);

        // Event listener for the Enter key press in the textarea
        userInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault(); // Prevent new line from being added
                handleSendMessage();
            }
        });
    </script>
</body>
</html>
