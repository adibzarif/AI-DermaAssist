<!-- Floating Shopping Checklist Panel -->
<div id="checklist-panel">
    <div class="panel-header">
        <div class="panel-header-left">
            <div class="panel-icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M3 4h12M3 9h8M3 14h5" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="15" cy="13" r="3" fill="white"/>
                    <path d="M13.5 13l1 1 2-2" stroke="#C4956A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <div class="panel-title">My Shopping List</div>
                <div class="panel-subtitle" id="panel-count-text">0 items selected</div>
            </div>
        </div>
        <button class="panel-toggle-btn" id="panel-collapse-btn" title="Collapse" onclick="togglePanelCollapse()">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M4 10l4-4 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

    <div class="panel-body" id="panel-body">
        <div id="checklist-items"></div>

        <div class="panel-divider"></div>

        <div class="panel-total">
            <div>
                <div class="total-label">Estimated Total</div>
                <div class="total-note" id="panel-tba-note" style="display:none;">* some prices unavailable</div>
            </div>
            <div class="total-value">
                <span class="currency">RM&nbsp;</span><span id="panel-total-val">0.00</span>
            </div>
        </div>

        <div class="panel-actions">
            <button class="panel-btn-clear" onclick="clearAll()">Clear All</button>
            <button class="panel-btn-save" onclick="openReceipt()">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <rect x="1" y="1" width="12" height="12" rx="2" stroke="white" stroke-width="1.5"/>
                    <path d="M4 5h6M4 7.5h4" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                View Summary
            </button>
        </div>
    </div>
</div>

<!-- FAB (shown when panel is dismissed) -->
<div id="checklist-fab" onclick="showPanel()">
    <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
        <path d="M4 5h14M4 11h10M4 17h7" stroke="white" stroke-width="2" stroke-linecap="round"/>
    </svg>
    <div id="checklist-fab-count">0</div>
</div>
