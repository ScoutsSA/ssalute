# Feature Spec: Financial Management

## Overview

Each Scout group maintains one or more financial accounts. Financial years are defined per group, fees are charged to members, invoices are issued, and payments are recorded. Credit notes handle adjustments. The backoffice panel (admin) provides full financial oversight across all groups, while the general panel (group leaders/admins) provides self-service access to their own group's finances.

---

## Key Models

| Model | Table | Purpose |
|---|---|---|
| `GroupAccount` | `group_accounts` | Main financial account per group |
| `GroupFinancialYear` | `group_financial_years` | Financial year definitions per group |
| `GroupFinancialFee` | `group_financial_fees` | Individual fee records per member |
| `GroupFinancialFeeType` | `group_financial_fee_types` | Fee type definitions per group |
| `SystemFinancialFeeType` | `system_financial_fee_types` | System-level fee type reference |
| `GroupFinancialInvoice` | `group_financial_invoices` | Invoice records |
| `GroupFinancialInvoicesItem` | `group_financial_invoices_items` | Invoice line items |
| `GroupFinancialInvoicesEmailed` | `group_financial_invoices_emailed` | Invoice delivery tracking |
| `GroupFinancialPaymentsMade` | `group_financial_payments_made` | Payment records |
| `GroupFinancialCreditNote` | `group_financial_credit_notes` | Credit note records |
| `GroupFinancialCreditNotesItem` | `group_financial_credit_notes_items` | Credit note line items |
| `GroupFinancialAnnualInvoiceDiscount` | `group_financial_annual_invoice_discounts` | Bulk annual discounts |
| `GroupAccountsTransfer` | `group_accounts_transfers` | Inter-group account transfers |
| `GroupAccountTransfersNote` | _(see model)_ | Transfer notes/comments |
| `GroupAccountsTransfersStage` | _(see model)_ | Transfer status stages |
| `PaymentType` | `payment_types` | Payment method definitions |
| `SystemAccountType` | `system_account_types` | Account type definitions |

---

## Backoffice Panel (Admin)

### Resource Location

`app/Filament/Admin/Clusters/Settings` or a dedicated `Financial` cluster under `app/Filament/Admin/Clusters/Financial/`.

### 1. Group Accounts — List & Search

- List all `GroupAccount` records.
- Searchable by group name, region, and active status.
- Columns: Group, Account Type (`SystemAccountType`), Current Balance, Active, Actions.
- Filter by region, district, active/inactive.

### 2. Account Statement

- View a running balance for a selected `GroupAccount`.
- All transactions listed chronologically: invoices raised, payments received, credit notes applied, transfers in/out.
- Show opening balance per financial year.
- Export to CSV/PDF.

### 3. Add Payment to Account

- Select `GroupAccount`.
- Select `PaymentType`.
- Enter amount, date, reference, notes.
- Creates a `GroupFinancialPaymentsMade` record.
- Updates account running balance.

### 4. Invoice Management

- List invoices for a group (`GroupFinancialInvoice`), filterable by financial year, status (draft, sent, paid, void).
- View invoice detail (header + line items from `GroupFinancialInvoicesItem`).
- Create new invoice:
  - Select group and financial year.
  - Add one or more line items (description, quantity, unit price, fee type).
  - Save as draft or immediately send.
- Mark invoice as paid (links to a payment record).
- Void an invoice (with reason).
- Track email delivery via `GroupFinancialInvoicesEmailed`.

### 5. Invoice Line Items

- Add, edit, or remove `GroupFinancialInvoicesItem` records on a draft invoice.
- Fields: description, fee type (`GroupFinancialFeeType`), quantity, unit price, subtotal.

### 6. Bulk Annual Invoice Generation

- Select a financial year, optionally filter by region or district.
- Preview the list of groups that will receive invoices.
- Apply annual discounts from `GroupFinancialAnnualInvoiceDiscount`.
- Confirm and dispatch a queued job to generate invoices for all selected groups.
- Progress feedback via Filament notifications.

### 7. Credit Note Management

- List credit notes (`GroupFinancialCreditNote`) per group.
- View credit note detail with line items (`GroupFinancialCreditNotesItem`).
- Create credit note against an existing invoice (partial or full).
- Apply credit note to reduce outstanding balance.

### 8. Account Transfers (with Approval Workflow)

- Initiate a transfer between two `GroupAccount` records.
- Fields: source account, destination account, amount, reason, supporting notes (`GroupAccountTransfersNote`).
- Transfer progresses through stages (`GroupAccountsTransfersStage`): Requested → Reviewed → Approved/Rejected → Completed.
- Each stage transition requires an authorised admin action.
- Notifications sent to relevant parties at each stage.

### 9. Fee Type Configuration

- Manage `GroupFinancialFeeType` records per group.
- Link to `SystemFinancialFeeType` as the base reference.
- Fields: name, description, default amount, active.
- Per-group overrides of system fee types are supported.

### 10. Financial Year Configuration

- Create and manage `GroupFinancialYear` records per group.
- Fields: label (e.g. "2026"), start date, end date, active/closed.
- Only one financial year may be active per group at a time.

### 11. Financial Reports

- **Income Report:** Payments received grouped by group/region/district/date range.
- **Outstanding Balances Report:** Groups with unpaid invoices; shows amount overdue.
- **By Region Report:** Aggregate totals per region, drillable to district and group.
- All reports exportable to CSV.

---

## General Panel (Group Leader / Group Admin)

### Resource Location

`app/Filament/General/` — dedicated pages under a Financial section, scoped to the authenticated user's group.

### 1. Account Balance & Statement

- View current balance for own group's `GroupAccount`.
- View transaction history (invoices, payments, credit notes, transfers) in chronological order.
- Filter by financial year.

### 2. View Own Invoices

- List invoices for own group.
- Filter by status (outstanding, paid, void).
- View invoice detail and line items.
- Download invoice as PDF.

### 3. Pay Outstanding Invoice

- Select an outstanding invoice.
- Upload proof of payment (image or PDF).
- Enter payment date and reference.
- Submission notifies admin for confirmation.

### 4. View Credit Notes

- List credit notes applied to own group's account.
- View credit note detail.

### 5. Payment History

- View all `GroupFinancialPaymentsMade` records for own group.
- Filter by date range and payment type.

---

## Tests Required

### Feature Tests (`tests/Feature/Financial/`)

1. **Super admin can access financial management pages**
   - Assert admin can view account list, statement, invoice list, credit note list, transfer list.

2. **Group leader can only view their own group's finances**
   - Assert group leader sees their own account balance and invoices.
   - Assert group leader cannot access another group's account or invoices (403/404).

3. **Invoice creation validation**
   - Assert invoice cannot be saved without a financial year.
   - Assert invoice cannot be saved without at least one line item.
   - Assert draft invoice can be saved and then edited.

4. **Annual bulk invoice generation workflow**
   - Assert bulk generation dispatches the correct queued job.
   - Assert job creates `GroupFinancialInvoice` records for all targeted groups.
   - Assert annual discounts are applied where configured.

5. **Account transfer approval workflow**
   - Assert transfer is created in "Requested" stage.
   - Assert only an authorised admin can advance to "Approved".
   - Assert completing the transfer updates both account balances correctly.

6. **Payment recording updates account balance**
   - Assert that recording a `GroupFinancialPaymentsMade` against an invoice updates the `GroupAccount` running balance.
   - Assert marking invoice as paid reflects correctly in account statement.
