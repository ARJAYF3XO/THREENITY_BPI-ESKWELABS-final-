<?php
session_start();

// Collect POST data
$preset_name = $_POST['preset_name'] ?? 'Simulation Results';
$user_prompt = $_POST['user_prompt'] ?? '';
$final_prompt = $_POST['final_prompt'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($preset_name) ?> - Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Marked.js (for markdown -> HTML fallback) -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>
<body class="bg-custom-primary text-custom-primary d-flex flex-column min-vh-100">

<?php include '../navbar.php'; ?>

<div class="container py-5 flex-grow-1">
    <div class="card card-custom p-4 card-border-primary">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($preset_name) ?> - Results</h2>

        <?php if (!empty($user_prompt)): ?>
            <div class="mb-4">
                <h5>User Request</h5>
                <div class="p-3 border rounded bg-light text-dark">
                    <?= nl2br(htmlspecialchars($user_prompt)) ?>
                </div>
            </div>
        <?php endif; ?>

<div class="mb-4">
            <!-- ✅ Step Navigation -->
            <div class="stepper mb-4 text-center">
                <div class="step step-link-1" data-target="sim1_view.php">
                    <div class="circle">1</div>
                    <div class="label">Profile</div>
                </div>
                <div class="line"></div>
                <div class="step step-link-2" data-target="sim2_view.php">
                    <div class="circle">2</div>
                    <div class="label">Simulation</div>
                </div>
                <div class="line"></div>    
                <div class="step active step-link-3" data-target="sim1_view.php">
                    <div class="circle">3</div>
                    <div class="label">Results</div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <h5 class="mb-3">Simulation Output</h5>

        <!-- Loading bar -->
        <div id="loadingWrap" class="mb-3">
            <div class="progress" style="height: 24px;">
                <div id="loadingBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%">
                    <span id="loadingLabel" class="ms-2">Generating… 0%</span>
                </div>
            </div>
        </div>

        <!-- Results container -->
        <div id="resultBox" class="p-3 border rounded bg-white text-dark"
             style="min-height:220px; white-space:normal; overflow:auto;">
            ⏳ Waiting for AI to respond…
        </div>

        <!-- Debug toggle -->
        <details class="mt-3">
            <summary class="text-muted">Debug (raw AI text)</summary>
            <pre id="rawOutput" class="mt-2 small text-muted" style="white-space:pre-wrap;"></pre>
        </details>

        
    </div>
</div>

<?php include '../footer.php'; ?>

<!-- Load config -->
<script src="config.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const resultBox   = document.getElementById('resultBox');
    const rawBox      = document.getElementById('rawOutput');
    const loadingWrap = document.getElementById('loadingWrap');
    const loadingBar  = document.getElementById('loadingBar');
    const loadingLbl  = document.getElementById('loadingLabel');
    const prompt      = <?= json_encode($final_prompt) ?>;

    // Progress bar animation
    let prog = 0;
    const timer = setInterval(() => {
        const delta = prog < 60 ? 3 : (prog < 85 ? 1.5 : 0.5);
        prog = Math.min(prog + delta, 95);
        loadingBar.style.width = prog + '%';
        loadingLbl.textContent = 'Generating… ' + Math.round(prog) + '%';
    }, 120);

    function finishProgress() {
        clearInterval(timer);
        loadingBar.style.width = '100%';
        loadingLbl.textContent = 'Finalizing… 100%';
        setTimeout(() => { loadingWrap.style.display = 'none'; }, 400);
    }

    // ---- Enhanced Chart Helper Functions ----
    function waitForChartJS(callback) {
        if (typeof Chart !== 'undefined') {
            callback();
        } else {
            console.log('⏳ Waiting for Chart.js...');
            setTimeout(() => waitForChartJS(callback), 100);
        }
    }

    function ensureCanvasReady(container) {
        container.querySelectorAll('canvas').forEach(canvas => {
            // Set explicit dimensions if not set
            if (!canvas.style.width && !canvas.width) {
                canvas.style.width = '100%';
                canvas.style.height = '400px';
            }
            
            // Ensure canvas is visible
            if (canvas.style.display === 'none') {
                canvas.style.display = 'block';
            }
            
            // Add loading indicator
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'text-center text-muted mt-2';
            loadingDiv.innerHTML = '⏳ Loading chart...';
            loadingDiv.setAttribute('data-chart-loading', canvas.id);
            canvas.parentNode.insertBefore(loadingDiv, canvas.nextSibling);
        });
    }

    function executeEmbeddedScripts(container) {
        container.querySelectorAll('script').forEach(oldScript => {
            waitForChartJS(() => {
                const newScript = document.createElement('script');
                
                // Enhanced script content with error handling
                const scriptContent = `
                    try {
                        console.log('🔧 Executing chart script...');
                        ${oldScript.textContent}
                    } catch (error) {
                        console.error('❌ Chart script error:', error);
                        // Fallback: show error message in place of chart
                        const canvasElements = document.querySelectorAll('canvas');
                        canvasElements.forEach(canvas => {
                            if (!canvas.chart) {
                                const ctx = canvas.getContext('2d');
                                ctx.fillStyle = '#f8f9fa';
                                ctx.fillRect(0, 0, canvas.width, canvas.height);
                                ctx.fillStyle = '#dc3545';
                                ctx.font = '16px Arial';
                                ctx.textAlign = 'center';
                                ctx.fillText('Chart Error: ' + error.message, canvas.width/2, canvas.height/2);
                            }
                        });
                    }
                `;
                
                if (oldScript.textContent) {
                    newScript.textContent = scriptContent;
                }
                if (oldScript.src) {
                    newScript.src = oldScript.src;
                }
                
                document.body.appendChild(newScript);
                
                // Keep script for debugging
                setTimeout(() => {
                    console.log('🗑️ Cleaning up script element');
                    if (newScript.parentNode) {
                        newScript.remove();
                    }
                }, 1000);
            });
        });
    }

    function debugCharts() {
        console.log('🔍 Chart Debug Info:');
        console.log('Chart.js available:', typeof Chart !== 'undefined');
        console.log('Canvas elements found:', document.querySelectorAll('canvas').length);
        
        document.querySelectorAll('canvas').forEach((canvas, index) => {
            console.log(`Canvas ${index + 1}:`, {
                id: canvas.id,
                dimensions: `${canvas.width}x${canvas.height}`,
                style: canvas.style.cssText,
                hasChart: !!canvas.chart,
                visible: canvas.offsetWidth > 0 && canvas.offsetHeight > 0
            });
        });
    }

    // ---- Enhanced Helper Functions ----
    function stripWrappersAndPHP(s) {
        if (!s) return '';
        return s
            .replace(/```[\s\S]*?```/g, m => m.replace(/```(html|md|markdown)?/gi, '').replace(/```/g, ''))
            .replace(/<!DOCTYPE html>/gi, '')
            .replace(/<html[^>]*>/gi, '')
            .replace(/<\/html>/gi, '')
            .replace(/<head>[\s\S]*?<\/head>/gi, '')
            .replace(/<body[^>]*>/gi, '')
            .replace(/<\/body>/gi, '')
            .replace(/<\?php[\s\S]*?\?>/gi, '')
            .replace(/echo\s+["'`][\s\S]*?["'`];?/gi, '')
            .replace(/\$[a-zA-Z_][a-zA-Z0-9_]*/g, '');
    }

    function looksLikeMarkdown(s) {
        return /(^|\n)\s{0,3}(#{1,6}\s)|(\n\* |\n- |\n\d+\. )|(\n\|.*\|)/.test(s);
    }

    // ---- Enhanced Table Processing Functions ----
    function fixEmptyTables(container) {
        container.querySelectorAll('table').forEach(table => {
            console.log('🔧 Processing table:', table);
            
            // Check if table has any actual content
            const hasContent = table.querySelector('td, th');
            if (!hasContent) {
                console.log('⚠️ Empty table detected, attempting to fix...');
                
                // Try to find table data in nearby text or comments
                let tableParent = table.parentElement;
                let foundData = false;
                
                // Look for table data patterns in surrounding text
                const surroundingText = tableParent.textContent || '';
                const tablePatterns = [
                    /\|[^|]+\|[^|]+\|/, // Markdown table pattern
                    /:\s*₱[\d,]+/, // Currency patterns
                    /Taon\s*\|\s*[^|]+/, // Year patterns
                    /\d+\s*\|\s*₱/ // Number | Currency patterns
                ];
                
                for (let pattern of tablePatterns) {
                    if (pattern.test(surroundingText)) {
                        foundData = true;
                        break;
                    }
                }
                
                if (foundData) {
                    // Create a fallback table with basic structure
                    createFallbackTable(table);
                } else {
                    // Hide empty tables
                    table.style.display = 'none';
                    console.log('🚫 Hiding empty table');
                }
            }
        });
    }

    function createFallbackTable(table) {
        // Create basic table structure if completely empty
        const fallbackHTML = `
            <thead class="table-dark">
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" class="text-center text-muted">
                        <em>Table data not available - please check the raw output for details</em>
                    </td>
                </tr>
            </tbody>
        `;
        table.innerHTML = fallbackHTML;
        console.log('🔧 Created fallback table structure');
    }

    function addBootstrapTableClasses(container) {
        container.querySelectorAll('table').forEach(t => {
            // Add Bootstrap classes
            t.classList.add('table', 'table-striped', 'table-bordered', 'table-hover');
            
            // Ensure proper table structure
            if (!t.querySelector('thead') && t.rows.length > 0) {
                const thead = t.createTHead();
                const firstRow = t.rows[0];
                if (firstRow) {
                    // Move first row to thead and make cells th elements
                    const newHeaderRow = thead.insertRow();
                    while (firstRow.cells.length > 0) {
                        const cell = firstRow.cells[0];
                        const th = document.createElement('th');
                        th.innerHTML = cell.innerHTML;
                        th.scope = 'col';
                        newHeaderRow.appendChild(th);
                        cell.remove();
                    }
                    firstRow.remove();
                }
            }
            
            if (!t.querySelector('tbody') && t.rows.length > 0) {
                const tbody = document.createElement('tbody');
                const rows = Array.from(t.rows);
                // Skip the first row if it's now in thead
                const startIndex = t.querySelector('thead') ? 0 : 1;
                rows.slice(startIndex).forEach(r => tbody.appendChild(r));
                t.appendChild(tbody);
            }
            
            // Add responsive wrapper if not already present
            if (!t.parentElement.classList.contains('table-responsive')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-responsive';
                t.parentNode.insertBefore(wrapper, t);
                wrapper.appendChild(t);
            }
        });
    }

    // ---- Enhanced Content Processing ----
    function processMarkdownTables(markdown) {
        // Improved markdown table processing
        const tableRegex = /\|(.+)\|\s*\n\|[-\s|:]+\|\s*\n((?:\|.+\|\s*\n?)+)/g;
        
        return markdown.replace(tableRegex, (match, header, rows) => {
            console.log('🔧 Processing markdown table...');
            
            const headerCells = header.split('|').map(cell => cell.trim()).filter(cell => cell);
            const rowsArray = rows.trim().split('\n').map(row => 
                row.split('|').map(cell => cell.trim()).filter(cell => cell)
            );
            
            let tableHTML = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover">\n';
            
            // Header
            if (headerCells.length > 0) {
                tableHTML += '<thead class="table-dark"><tr>';
                headerCells.forEach(cell => {
                    tableHTML += `<th scope="col">${cell}</th>`;
                });
                tableHTML += '</tr></thead>\n';
            }
            
            // Body
            if (rowsArray.length > 0) {
                tableHTML += '<tbody>';
                rowsArray.forEach(row => {
                    if (row.length > 0) {
                        tableHTML += '<tr>';
                        row.forEach(cell => {
                            tableHTML += `<td>${cell}</td>`;
                        });
                        tableHTML += '</tr>';
                    }
                });
                tableHTML += '</tbody>';
            }
            
            tableHTML += '</table></div>';
            return tableHTML;
        });
    }

    try {
        console.log("🔹 Sending final prompt:", prompt);

        const url = `https://generativelanguage.googleapis.com/v1beta/models/${window.MODEL_NAME}:generateContent?key=${window.API_KEY}`;

        const response = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ contents: [{ parts: [{ text: prompt }] }] })
        });

        if (!response.ok) {
            finishProgress();
            resultBox.innerHTML = `<div class="alert alert-danger mb-0">
                <strong>Error:</strong> ${response.status} ${response.statusText}
            </div>`;
            return;
        }

        const data = await response.json();
        console.log("🔹 API response:", data);

        const rawText = data?.candidates?.[0]?.content?.parts?.[0]?.text || "";
        rawBox.textContent = rawText || "(empty response)";

        if (!rawText.trim()) {
            resultBox.innerHTML = `<div class="alert alert-warning mb-0">
                ⚠️ AI returned an empty response. Try adjusting your prompt.
            </div>`;
            finishProgress();
            return;
        }

        let cleaned = stripWrappersAndPHP(rawText);

        let htmlOut = cleaned;
        if (looksLikeMarkdown(cleaned)) {
            try {   
                // Process markdown tables before general markdown parsing
                cleaned = processMarkdownTables(cleaned);
                htmlOut = marked.parse(cleaned);
            } catch(e) {
                console.warn("Markdown parse error:", e);
                htmlOut = `<pre>${cleaned.replace(/[<>&]/g, c => ({'<':'&lt;','>':'&gt;','&':'&amp;'}[c]))}</pre>`;
            }
        }

        resultBox.innerHTML = htmlOut;
        
        // Enhanced table processing
        fixEmptyTables(resultBox);
        addBootstrapTableClasses(resultBox);

        // Enhanced chart handling
        ensureCanvasReady(resultBox);

        // Wait for DOM to settle before executing scripts
        setTimeout(() => {
            executeEmbeddedScripts(resultBox);
            
            // Cleanup loading indicators after a delay
            setTimeout(() => {
                document.querySelectorAll('[data-chart-loading]').forEach(el => {
                    el.remove();
                });
            }, 3000);
            
            // Debug charts after execution
            setTimeout(debugCharts, 2000);
        }, 100);

        finishProgress();

    } catch (err) {
        console.error("❌ Fetch error:", err);
        finishProgress();
        resultBox.innerHTML = `<div class="alert alert-danger mb-0">
            <strong>Error:</strong> ${err.message}
        </div>`;
    }
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

    document.querySelectorAll(".step-link-2").forEach(link => {
        link.addEventListener("click", function (e) {
            const target = this.getAttribute("data-target");
            if (this.classList.contains("active")) return;

            const confirmLeave = confirm("go back to step 2?");
            if (confirmLeave) {
                window.location.href = target;
            } else {
                e.preventDefault();
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>