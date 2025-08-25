<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulation Step 2 - Choose & Configure Simulation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-custom-primary text-custom-primary d-flex flex-column min-vh-100">

<?php include '../navbar.php'; ?>

<div class="container py-5 flex-grow-1">
    <div class="card card-custom p-4 card-border-primary">

        <!-- ✅ Step Navigation -->
       <!-- ✅ Step Navigation -->
<div class="mb-4">
            <!-- ✅ Step Navigation -->
            <div class="stepper mb-4 text-center">
                <div class="step step-link-1" data-target="sim1_view.php">
                    <div class="circle">1</div>
                    <div class="label">Profile</div>
                </div>
                <div class="line"></div>
                <div class="step active step-link-2" data-target="sim2_view.php">
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


        <h2 class="mb-4 text-center">Select a Simulation</h2>

        <div id="alertBox" class="alert d-none" role="alert"></div> 

        <div class="mb-4 text-center">
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="btn btn-outline-primary" data-preset="Retirement Planning">Retirement Planning</button>
                <button class="btn btn-outline-primary" data-preset="Buying a House">Buying a House</button>
                <button class="btn btn-outline-primary" data-preset="Car Purchase">Car Purchase</button>
                <button class="btn btn-outline-primary" data-preset="Emergency Fund">Emergency Fund</button>
                <button class="btn btn-outline-primary" data-preset="Debt Repayment Plan">Debt Repayment Plan</button>
                <button class="btn btn-outline-primary" data-preset="Education Fund">Education Fund</button>
                <button class="btn btn-outline-primary" data-preset="Investment Growth">Investment Growth</button>
                <button class="btn btn-outline-primary" data-preset="Savings Goal">Savings Goal</button>
            </div>
        </div>

        <div id="formContainer" class="border p-3 rounded mb-3 d-none bg-white"></div>

        <div class="d-grid">
            <button id="runSimulationBtn" class="btn btn-success d-none">Run Simulation</button>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>

<script src="config.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    function formatUserProfile(profile) {
        if (!profile || Object.keys(profile).length === 0) return "No user profile available.";
        let lines = [];
        for (const [key, value] of Object.entries(profile)) {
            if (value !== null && value !== "" && value !== undefined) {
                const cleanKey = key.replace(/_/g, " ").replace(/\b\w/g, c => c.toUpperCase());
                lines.push(`${cleanKey}: ${value}`);
            }
        }
        return lines.join("\n");
    }

    function showAlert(type, message) {
        const alertBox = document.getElementById('alertBox');
        alertBox.className = `alert alert-${type}`;
        alertBox.textContent = message;
        alertBox.classList.remove('d-none');
    }

    let currentPreset = null;
    window.USER_PROFILE = {};

    async function loadUserProfile() {
        try {
            const resp = await fetch("get_user_profile.php");
            const data = await resp.json();
            if (data.error) {
                showAlert('warning', data.error);
                window.USER_PROFILE = {};
            } else {
                showAlert('success', "Select a Simulation.");
                window.USER_PROFILE = data.profile;
            }
        } catch (err) {
            showAlert('danger', "Error loading profile: " + err.message);
            window.USER_PROFILE = {};
        }
    }
    loadUserProfile();

    const UNIVERSAL_FIELDS = `
        <div class="mb-3">
            <label>Financial Literacy (1-5)</label>
            <input name="literacy" type="range" min="1" max="5" class="form-range">
        </div>
        <div class="mb-3">
            <label>Language Preference</label>
            <select name="language" class="form-select">
                <option value="English">English</option>
                <option value="Tagalog">Tagalog</option>
                <option value="Mixed">Mixed</option>
            </select>
        </div>
    `;

    const PRESET_FORMS = {
        "Retirement Planning": `
            <div class="mb-3"><label>Current Age</label><input name="current_age" type="number" class="form-control"></div>
            <div class="mb-3"><label>Retirement Age</label><input name="retirement_age" type="number" class="form-control"></div>
            <div class="mb-3"><label>Monthly Contribution</label><input name="monthly_contribution" type="number" class="form-control"></div>
            <div class="mb-3"><label>Expected Annual Return (%)</label><input name="annual_return" type="number" class="form-control"></div>
            <div class="mb-3"><label>Desired Retirement Income</label><input name="retirement_income" type="number" class="form-control"></div>
            ${UNIVERSAL_FIELDS}
        `,
        "Buying a House": `
            <div class="mb-3"><label>House Price</label><input name="house_price" type="number" class="form-control"></div>
            <div class="mb-3"><label>Down Payment</label><input name="down_payment" type="number" class="form-control"></div>
            <div class="mb-3"><label>Mortgage Term (years)</label><input name="mortgage_term" type="number" class="form-control"></div>
            <div class="mb-3"><label>Interest Rate (%)</label><input name="interest_rate" type="number" class="form-control"></div>
            <div class="mb-3"><label>Property Taxes / Insurance</label><input name="property_costs" type="number" class="form-control"></div>
            ${UNIVERSAL_FIELDS}
        `,
        "Car Purchase": `
            <div class="mb-3"><label>Car Price</label><input name="car_price" type="number" class="form-control"></div>
            <div class="mb-3"><label>Down Payment</label><input name="down_payment" type="number" class="form-control"></div>
            <div class="mb-3"><label>Loan Term (years)</label><input name="loan_term" type="number" class="form-control"></div>
            <div class="mb-3"><label>Interest Rate (%)</label><input name="interest_rate" type="number" class="form-control"></div>
            <div class="mb-3"><label>Monthly Insurance & Maintenance</label><input name="monthly_maintenance" type="number" class="form-control"></div>
            ${UNIVERSAL_FIELDS}
        `,
        "Emergency Fund": `
            <div class="mb-3"><label>Coverage Months</label><input name="coverage_months" type="number" class="form-control"></div>
            <div class="mb-3">
                <label>Expense Type</label>
                <select name="expense_type" class="form-select">
                    <option value="essentials">Essentials Only</option>
                    <option value="lifestyle">Essentials + Lifestyle</option>
                    <option value="full">Full Expenses</option>
                </select>
            </div>
            ${UNIVERSAL_FIELDS}
        `,
        "Debt Repayment Plan": `
            <div class="mb-3"><label>Debt List</label><textarea name="debt_list" class="form-control"></textarea></div>
            <div class="mb-3"><label>Monthly Budget for Debt</label><input name="monthly_budget" type="number" class="form-control"></div>
            <div class="mb-3">
                <label>Strategy Preference</label>
                <select name="strategy" class="form-select">
                    <option value="snowball">Snowball</option>
                    <option value="avalanche">Avalanche</option>
                </select>
            </div>
            ${UNIVERSAL_FIELDS}
        `,
        "Education Fund": `
            <div class="mb-3"><label>Tuition Target (per year)</label><input name="tuition_target" type="number" class="form-control"></div>
            <div class="mb-3"><label>Years Until Start</label><input name="years_until_start" type="number" class="form-control"></div>
            <div class="mb-3"><label>Years of Schooling</label><input name="years_schooling" type="number" class="form-control"></div>
            <div class="mb-3"><label>Expected Annual Return (%)</label><input name="annual_return" type="number" class="form-control"></div>
            ${UNIVERSAL_FIELDS}
        `,
        "Investment Growth": `
            <div class="mb-3"><label>Initial Capital</label><input name="initial_capital" type="number" class="form-control"></div>
            <div class="mb-3"><label>Monthly Contribution</label><input name="monthly_contribution" type="number" class="form-control"></div>
            <div class="mb-3"><label>Annual Return (%)</label><input name="annual_return" type="number" class="form-control"></div>
            <div class="mb-3"><label>Years to Invest</label><input name="years_to_invest" type="number" class="form-control"></div>
            <div class="mb-3">
                <label>Risk Appetite</label>
                <select name="risk_appetite" class="form-select">
                    <option value="conservative">Conservative</option>
                    <option value="moderate">Moderate</option>
                    <option value="aggressive">Aggressive</option>
                </select>
            </div>
            ${UNIVERSAL_FIELDS}
        `,
        "Savings Goal": `
            <div class="mb-3"><label>Goal Amount</label><input name="goal_amount" type="number" class="form-control"></div>
            <div class="mb-3"><label>Timeframe (months)</label><input name="timeframe_months" type="number" class="form-control"></div>
            <div class="mb-3"><label>Monthly Contribution</label><input name="monthly_contribution" type="number" class="form-control"></div>
            <div class="mb-3">
                <label>Goal Type</label>
                <select name="goal_type" class="form-select">
                    <option value="travel">Travel</option>
                    <option value="gadget">Gadget</option>
                    <option value="wedding">Wedding</option>
                    <option value="other">Other</option>
                </select>
            </div>
            ${UNIVERSAL_FIELDS}
        `
    };

    const PRESET_PROMPT_MAP = {
        "Retirement Planning": "retirement",
        "Buying a House": "buying_house",
        "Car Purchase": "car_purchase",
        "Education Fund": "education",
        "Emergency Fund": "emergency_fund",
        "Investment Growth": "investment",
        "Debt Repayment Plan": "debt_repayment",
        "Savings Goal": "savings_goal"
    };

    // Monte Carlo Simulation Functions
    function generateRandomReturn(expectedReturn, volatility = 0.15) {
        // Box-Muller transformation for normal distribution
        const u1 = Math.random();
        const u2 = Math.random();
        const z = Math.sqrt(-2 * Math.log(u1)) * Math.cos(2 * Math.PI * u2);
        return expectedReturn + (volatility * expectedReturn * z);
    }

    function runMonteCarloSimulation(formData, simulationType, iterations = 1000) {
        const results = [];
        
        for (let i = 0; i < iterations; i++) {
            let outcome = 0;
            
            switch (simulationType) {
                case "Retirement Planning":
                    outcome = simulateRetirement(formData);
                    break;
                case "Investment Growth":
                    outcome = simulateInvestment(formData);
                    break;
                case "Education Fund":
                    outcome = simulateEducationFund(formData);
                    break;
                case "Savings Goal":
                    outcome = simulateSavingsGoal(formData);
                    break;
                default:
                    outcome = simulateGeneric(formData, simulationType);
                    break;
            }
            results.push(outcome);
        }
        
        return analyzeResults(results);
    }

    function simulateRetirement(data) {
        const years = (parseInt(data.retirement_age) || 65) - (parseInt(data.current_age) || 25);
        const monthlyContribution = parseFloat(data.monthly_contribution) || 1000;
        const expectedReturn = (parseFloat(data.annual_return) || 7) / 100;
        
        let balance = 0;
        for (let year = 0; year < years; year++) {
            const yearlyReturn = generateRandomReturn(expectedReturn);
            balance = balance * (1 + yearlyReturn) + (monthlyContribution * 12);
        }
        return balance;
    }

    function simulateInvestment(data) {
        const initialCapital = parseFloat(data.initial_capital) || 10000;
        const monthlyContribution = parseFloat(data.monthly_contribution) || 500;
        const years = parseInt(data.years_to_invest) || 10;
        const expectedReturn = (parseFloat(data.annual_return) || 8) / 100;
        
        let balance = initialCapital;
        for (let year = 0; year < years; year++) {
            const yearlyReturn = generateRandomReturn(expectedReturn);
            balance = balance * (1 + yearlyReturn) + (monthlyContribution * 12);
        }
        return balance;
    }

    function simulateEducationFund(data) {
        const tuitionTarget = parseFloat(data.tuition_target) || 50000;
        const yearsUntilStart = parseInt(data.years_until_start) || 10;
        const yearsSchooling = parseInt(data.years_schooling) || 4;
        const expectedReturn = (parseFloat(data.annual_return) || 6) / 100;
        
        // Calculate needed savings
        const totalCost = tuitionTarget * yearsSchooling;
        const monthlyNeeded = totalCost / (yearsUntilStart * 12);
        
        let balance = 0;
        for (let year = 0; year < yearsUntilStart; year++) {
            const yearlyReturn = generateRandomReturn(expectedReturn);
            balance = balance * (1 + yearlyReturn) + (monthlyNeeded * 12);
        }
        return balance;
    }

    function simulateSavingsGoal(data) {
        const goalAmount = parseFloat(data.goal_amount) || 10000;
        const timeframe = parseInt(data.timeframe_months) || 12;
        const monthlyContribution = parseFloat(data.monthly_contribution) || 500;
        
        // Simple savings with minor interest variation
        const months = timeframe;
        const monthlyRate = generateRandomReturn(0.005, 0.002); // ~6% annual with variation
        
        let balance = 0;
        for (let month = 0; month < months; month++) {
            balance = balance * (1 + monthlyRate) + monthlyContribution;
        }
        return balance;
    }

    function simulateGeneric(data, type) {
        // Generic simulation for other types
        const baseAmount = parseFloat(Object.values(data)[0]) || 10000;
        const variance = 0.2; // 20% variance
        return baseAmount * (1 + (Math.random() - 0.5) * variance);
    }

    function analyzeResults(results) {
        results.sort((a, b) => a - b);
        const length = results.length;
        
        return {
            mean: results.reduce((sum, val) => sum + val, 0) / length,
            median: results[Math.floor(length / 2)],
            percentile_10: results[Math.floor(length * 0.1)],
            percentile_25: results[Math.floor(length * 0.25)],
            percentile_75: results[Math.floor(length * 0.75)],
            percentile_90: results[Math.floor(length * 0.9)],
            min: results[0],
            max: results[length - 1],
            standardDeviation: Math.sqrt(results.reduce((sum, val) => {
                const mean = results.reduce((s, v) => s + v, 0) / length;
                return sum + Math.pow(val - mean, 2);
            }, 0) / length)
        };
    }

    function formatMonteCarloResults(results) {
        return `MONTE CARLO SIMULATION RESULTS (1000 iterations):
Mean Outcome: ${results.mean.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}
Median Outcome: ${results.median.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}
10th Percentile (Worst Case): ${results.percentile_10.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}
25th Percentile: ${results.percentile_25.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}
75th Percentile: ${results.percentile_75.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}
90th Percentile (Best Case): ${results.percentile_90.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}
Standard Deviation: ${results.standardDeviation.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}
Range: ${results.min.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })} - ${results.max.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`;
    }

    document.querySelectorAll('[data-preset]').forEach(btn => {
        btn.addEventListener('click', () => {
            currentPreset = btn.dataset.preset;
            document.getElementById('formContainer').innerHTML = PRESET_FORMS[currentPreset];
            document.getElementById('formContainer').classList.remove('d-none');
            document.getElementById('runSimulationBtn').classList.remove('d-none');
            showAlert('info', `Loaded form for ${currentPreset}`);
        });
    });

    document.getElementById('runSimulationBtn').addEventListener('click', () => {
        const formData = {};
        document.querySelectorAll('#formContainer [name]').forEach(input => {
            formData[input.name] = input.value;
        });

        showAlert('warning', 'Running Monte Carlo simulation...');

        // Run Monte Carlo simulation
        const monteCarloResults = runMonteCarloSimulation(formData, currentPreset);
        const formattedResults = formatMonteCarloResults(monteCarloResults);

        const profileText = formatUserProfile(window.USER_PROFILE);

        // Build final prompt with profile, simulation context, and Monte Carlo results
        const promptKey = PRESET_PROMPT_MAP[currentPreset];
        const basePrompt = window.PRESET_PROMPTS[promptKey].replace("{{USER_PROFILE}}", profileText);
        
        const finalPrompt = `${basePrompt}

SIMULATION CONTEXT:
${JSON.stringify(formData, null, 2)}

${formattedResults}

Please provide comprehensive financial advice based on the user profile, simulation parameters, and Monte Carlo analysis results.`;

        //alert("Final Prompt being sent to AI:\n\n" + finalPrompt);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'sim3_results.php';
        form.target = '_blank';
        form.innerHTML = `
            <input type="hidden" name="preset_name" value="${currentPreset}">
            <input type="hidden" name="user_prompt" value="${currentPreset}">
            <textarea name="final_prompt" style="display:none;">${finalPrompt}</textarea>
            <input type="hidden" name="monte_carlo_results" value="${encodeURIComponent(JSON.stringify(monteCarloResults))}">
        `;
        document.body.appendChild(form);
        form.submit();
        form.remove();

        showAlert('success', 'Monte Carlo simulation completed and results sent!');
    });

    document.querySelectorAll(".step-link-1").forEach(link => {
        link.addEventListener("click", function (e) {
            const target = this.getAttribute("data-target");
            if (this.classList.contains("active")) return;

            const confirmLeave = confirm("go back to step 1?");
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

            // alert box here 
                e.preventDefault();
            
        });
    });

}); // ✅ now properly closes DOMContentLoaded
</script>

</body>
</html>