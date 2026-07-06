<!-- Receipt / Summary Modal -->
<div class="receipt-modal-backdrop" id="receipt-backdrop" onclick="closeReceiptOutside(event)">
    <div class="receipt-modal">
        <div class="receipt-top">
            <div class="receipt-logo">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path d="M5 6h12M5 11h8M5 16h5" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="receipt-title">Store Shopping List</div>
            <div class="receipt-date" id="receipt-date"></div>
        </div>

        <div class="receipt-items" id="receipt-items-list"></div>

        <div class="receipt-total-row">
            <span class="receipt-total-label">Total</span>
            <span class="receipt-total-val" id="receipt-total-val">RM 0.00</span>
        </div>

        <p class="receipt-footer-note" id="receipt-footer-note"></p>

        <div class="receipt-modal-actions">
            <button class="receipt-close-btn" onclick="closeReceipt()">Close</button>
            <button class="receipt-print-btn" onclick="saveAndPrint()">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <rect x="1" y="4" width="12" height="8" rx="1.5" stroke="white" stroke-width="1.4"/>
                    <path d="M4 4V2h6v2" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                    <rect x="3.5" y="7" width="7" height="3.5" rx="0.5" fill="white"/>
                </svg>
                Print / Save
            </button>
        </div>
    </div>
</div>
