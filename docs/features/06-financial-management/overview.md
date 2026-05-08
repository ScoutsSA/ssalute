# Feature: Financial Management

> Module: Financial Management
> Panel(s): Admin (backoffice), Member
> Status: Planned — Needs Human Review
> Phase: 6

---

## What This Feature Does

Each Scout group maintains one or more financial accounts. The system manages financial years, fee types, invoices, payments, credit notes, and inter group account transfers. The admin backoffice provides full financial oversight and management across all groups, while the member panel gives group leaders self service access to their own group's finances.

---

## Admin Backoffice Requirements

### Group Accounts

- View and search all group financial accounts by group name, region, and active status.
- Filter by region, district, or active/inactive status.
- View the account type, current balance, and available actions for each account.

### Account Statements

- View a running balance for a selected group account showing all transactions (invoices raised, payments received, credit notes applied, transfers in and out) in chronological order.
- Show the opening balance per financial year.
- Export the statement to CSV or PDF.

### Record Payments

- Record a payment against a group account by selecting the payment type, entering the amount, date, reference, and notes.
- Recording a payment updates the account's running balance.

### Invoice Management

- View all invoices for a group, filterable by financial year and status (draft, sent, paid, void).
- View invoice details including all line items.
- Create a new invoice by selecting the group and financial year, then adding one or more line items (description, quantity, unit price, fee type). Save as draft or send immediately.
- Mark an invoice as paid by linking it to a payment record.
- Void an invoice with a reason.
- Track email delivery status for sent invoices.

### Invoice Line Items

- Add, edit, or remove line items on a draft invoice. Each line item includes a description, fee type, quantity, unit price, and calculated subtotal.

### Bulk Annual Invoice Generation

- Generate invoices in bulk for a selected financial year, optionally filtered by region or district.
- Preview the list of groups that will receive invoices before confirming.
- Apply any configured annual discounts automatically.
- Invoice generation runs as a background process with progress notifications.

### Credit Note Management

- View credit notes per group with full line item detail.
- Create a credit note against an existing invoice (partial or full).
- Apply a credit note to reduce the outstanding balance.

### Account Transfers (with Approval Workflow)

- Initiate a transfer between two group accounts, specifying the source, destination, amount, reason, and supporting notes.
- Transfers progress through an approval workflow: Requested, Reviewed, Approved (or Rejected), Completed.
- Each stage transition requires an authorised admin action.
- Relevant parties are notified at each stage.

### Fee Type Configuration

- Define fee types per group, linked to system level fee type definitions.
- Each fee type includes a name, description, default amount, and active status.
- Groups can override system level fee types with their own values.

### Financial Year Configuration

- Create and manage financial years per group with a label (e.g. "2026"), start date, end date, and active/closed status.
- Only one financial year may be active per group at a time.

### Financial Reports

- **Income Report.** Payments received, grouped by group, region, district, or date range.
- **Outstanding Balances Report.** Groups with unpaid invoices, showing the amount overdue.
- **By Region Report.** Aggregate totals per region, drillable down to district and group level.
- All reports are exportable to CSV.

---

## Member Panel Requirements

These features are available to group leaders and group admins, scoped to their own group only.

### Account Balance and Statement

- View the current balance for the group's financial account.
- View the full transaction history (invoices, payments, credit notes, transfers) in chronological order.
- Filter by financial year.

### View Invoices

- View all invoices for the group, filterable by status (outstanding, paid, void).
- View invoice detail and line items.
- Download an invoice as PDF.

### Pay an Outstanding Invoice

- Select an outstanding invoice and submit proof of payment (image or PDF) along with the payment date and reference.
- Submission notifies the admin for confirmation.

### View Credit Notes

- View credit notes applied to the group's account with full detail.

### Payment History

- View all payment records for the group.
- Filter by date range and payment type.

---

## Business Rules and Constraints

1. **One active financial year per group.** Only one financial year may be active for a given group at any time.
2. **Transfer approval workflow.** Account transfers between groups require a multi stage approval process. No transfer is completed without authorised admin approval at each stage.
3. **Group scoping in the member panel.** Group leaders can only view and interact with their own group's financial data. Attempting to access another group's finances is denied.
4. **Invoice lifecycle.** Invoices follow a defined lifecycle: draft, sent, paid, or void. Voiding an invoice requires a reason. Only draft invoices can have their line items modified.
5. **Bulk invoice generation runs in the background.** Annual invoice generation is processed as a background job to handle large volumes without blocking the admin interface.
6. **Credit notes reduce outstanding balances.** Credit notes are always issued against an existing invoice (partial or full) and reduce the account's outstanding balance accordingly.
