# Drop Unused Lookup And Commerce Tables

Panel: console

During the lookup table audit of 2026-08-27 (the audit that added the missing lookup resources to the BackOffice LookupTables cluster) two sets of tables were identified as removal candidates. The decision is to never build admin interfaces for these. This ticket marks them for removal from the shared database.

## Dead lookup tables

These lookup style tables have zero references anywhere in the legacy codebase. Verified on 2026-08-27 by grepping the legacy source for each table name. Re-derive that before actioning, do not trust this list blindly.

- `payment_types`
- `jamboree_payment_types`
- `jamboree_adult_roles`
- `support_ticket_priorities`
- `support_ticket_status`
- `system_awards_rovers_levels`
- `group_accounts_transfers_stages`

## Former lookup resources removed on 2026-08-27

Found while writing the legacy usage blurbs. These two had LookupTables resources although nothing reads their tables, so the resources were removed in the same change. The tables, models and factories remain and belong in the drop list:

- `system_financial_fee_types` has zero readers in the legacy codebase. The legacy app uses the per group `group_financial_fee_types` table instead. In Ssalute the only reference is the `chargeType` relation on the `GroupYouthCharge` model, itself an unused model of a nearly dead legacy feature (only a disable endpoint touches `group_youth_charges`). Remove that relation and model together with the table.
- `ams_training_courses_types` has zero readers in the legacy codebase. The nullable `courseType` column on `ams_training_courses` is never written or read by legacy either, and the Training Courses lookup page no longer offers it. Drop the column together with the table.

## Commerce module

The whole commerce module (the legacy on platform shop) is marked for removal. The BRD already lists the Shop as out of scope (section 2.2). Note that unlike the dead lookups above, a handful of commerce tables are still referenced by legacy shop pages (for example `commerce_products_cat`), so removing the tables also means retiring those legacy pages. All `commerce_` prefixed tables are included:

`commerce_cart`, `commerce_delivery_address`, `commerce_delivery_providers`, `commerce_delivery_providers_delivery_options`, `commerce_group_fees`, `commerce_order_status`, `commerce_orders`, `commerce_orders_details`, `commerce_payfast_transactions`, `commerce_products`, `commerce_products_cat`, `commerce_products_images`, `commerce_products_reviews`, `commerce_products_stock`, `commerce_products_sub_subcat`, `commerce_products_subcat`, `commerce_search_queries`, `commerce_shoppers_logins`, `commerce_stock_locations`, `commerce_stock_suppliers`, `commerce_wallet`, `commerce_wallets_transaction_types`, `commerce_wish_list`

## Scope when actioned

- Re-verify zero references in both the legacy codebase and Ssalute at the time of actioning.
- Take a final archive dump of every table before dropping it. `commerce_payfast_transactions` and `commerce_orders` hold historical financial records, archive them somewhere durable rather than assuming they are worthless.
- The drops happen on the shared production database that the legacy app also runs on, so they must be coordinated with a legacy deploy that removes the shop pages.
- Remove the corresponding Ssalute models for the dropped tables in the same change (the commerce tables have no Ssalute models; the dead lookups mostly do).
