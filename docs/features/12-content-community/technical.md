# Feature Spec: Content & Community

> Module: Content & Community
> Panel(s): Admin (backoffice), Member
> Status: PLANNED
> Phase: 10 — Content & Community

---

## Overview

The platform includes several community-facing features for sharing news, resources, and information across the organisation. The backoffice panel provides full content management and moderation tools. The member panel provides a read-focused experience for members, with limited creation capabilities for authorised users.

---

## Key Models

| Model | Table | Purpose |
|---|---|---|
| `SdArticle` | _(see model)_ | News and article records |
| `SdArticleCat` | _(see model)_ | Article category definitions |
| `InfoSharing` | _(see model)_ | Community-submitted information sharing posts |
| `InfoSharingType` | _(see model)_ | Info sharing post type definitions |
| `InfoSharingReview` | _(see model)_ | Review/moderation records for info sharing posts |
| `InfoSharingLike` | _(see model)_ | Like/reaction records on info sharing posts |
| `SystemFaq` | _(see model)_ | FAQ entries |
| `SystemFaqCat` | _(see model)_ | FAQ category definitions |
| `Project` | _(see model)_ | Community project records |
| `ProjectsFor` | _(see model)_ | Records linking projects to target beneficiaries |
| `ProjectsSupported` | _(see model)_ | Records marking projects as supported by the organisation |
| `SystemRoadmapLittle` | _(see model)_ | Public roadmap items |
| `GroupNewsletter` | _(see model)_ | Group-specific newsletter records |
| `GroupParentsCommitteeMinute` | _(see model)_ | Committee meeting minute records per group |

---

## Filament Cluster

**Location:** `app/Filament/Admin/Clusters/Content/`

The Content cluster groups all content and community management resources under the Admin panel.

---

## Backoffice Panel (Admin) Requirements

### 1. Articles Management

**Resource:** `app/Filament/Admin/Clusters/Content/Resources/ArticleResource.php`

#### List Articles

- **Columns:** Title, category, author, status (draft/published/archived), published at, created at
- **Filters:** Category, status, published date range
- **Search:** Title, body excerpt, author name
- **Sort:** Title, published at, created at

#### View Article

- **Displays:** Title, category, author, status, published at, full body content, attached images/files

#### Edit / Create Article

- **Fields:**
  - Title (required)
  - Category (`SdArticleCat` — select, with inline create)
  - Body (rich text editor)
  - Status (draft, published, archived)
  - Published at (date-time picker — allows scheduling)
  - Featured image (file upload)
  - Excerpt (short summary for list views)
  - Author (auto-filled with current admin user; overridable)
- **Validation:** Title required; body required; published at required when status is published

#### Publish / Unpublish / Archive

- **Type:** Row actions and header action on view page
- **Publish:** Sets status to published; sets published_at to now if not already set
- **Unpublish:** Sets status to draft; clears published_at
- **Archive:** Sets status to archived; article no longer visible in member panel

---

### 2. Info Sharing Moderation

**Resource:** `app/Filament/Admin/Clusters/Content/Resources/InfoSharingResource.php`

#### List Posts

- **Columns:** Title, type, submitted by, status (pending/approved/rejected), submitted at
- **Filters:** Type (`InfoSharingType`), status, submitted date range
- **Search:** Title, submitted by name
- **Bulk actions:** Bulk approve, Bulk reject

#### View Post

- **Displays:** Full post content, type, submitted by, submitted at, review history (`InfoSharingReview`), like count (`InfoSharingLike`)

#### Moderate Post

- **Type:** Custom action (row and header)
- **Modal fields:** Decision (approve/reject), moderation reason (required for rejection)
- **On approve:** Creates `InfoSharingReview` record with approved status; post becomes visible in member panel
- **On reject:** Creates `InfoSharingReview` record with rejected status and reason; submitter is notified by email

---

### 3. FAQ Management

**Resource:** `app/Filament/Admin/Clusters/Content/Resources/FaqResource.php`

#### List FAQs

- **Columns:** Question (truncated), category, active, sort order
- **Filters:** Category (`SystemFaqCat`), active status
- **Search:** Question, answer excerpt
- **Reorder:** Drag-and-drop sort order within each category

#### Edit / Create FAQ

- **Fields:**
  - Question (required)
  - Answer (rich text editor, required)
  - Category (`SystemFaqCat` — select, with inline create)
  - Active (toggle)
  - Sort order (integer, auto-assigned)
- **Validation:** Question required; answer required; category required

#### FAQ Category Management

- **Inline management** of `SystemFaqCat` records: create, rename, reorder, delete (blocked if FAQs exist in category)

---

### 4. Projects Management

**Resource:** `app/Filament/Admin/Clusters/Content/Resources/ProjectResource.php`

#### List Projects

- **Columns:** Name, for (beneficiary type from `ProjectsFor`), supported status, active
- **Filters:** Supported status, for type, active
- **Search:** Name, description excerpt

#### Edit / Create Project

- **Fields:**
  - Name (required)
  - Description (rich text editor)
  - For (select from `ProjectsFor` — e.g. environment, community, youth)
  - Supported (toggle — marks as officially supported via `ProjectsSupported`)
  - Active (toggle)
  - Images/attachments (file upload)

#### Mark as Supported / Unsupported

- **Type:** Row action
- **Behaviour:** Creates or removes a `ProjectsSupported` record; no other data changes

---

### 5. Roadmap Management

**Resource:** `app/Filament/Admin/Clusters/Content/Resources/RoadmapResource.php`

#### List Roadmap Items

- **Columns:** Title, status (planned/in-progress/completed/cancelled), target date, public (visible to members)
- **Filters:** Status, public visibility
- **Search:** Title, description excerpt

#### Edit / Create Roadmap Item

- **Fields:**
  - Title (required)
  - Description (textarea or short rich text)
  - Status (select: planned, in-progress, completed, cancelled)
  - Target date (date picker, optional)
  - Public (toggle — controls visibility in member panel)

---

## Member Panel Requirements

### Role Gating

- All read-only content pages are accessible to any authenticated user.
- Info sharing post creation requires an explicit role permission (configurable — not all members can create posts by default).
- Group newsletter and committee minutes are scoped to the user's active group.

---

### 1. Browse and Read Articles

- **Type:** List page and view page
- **Class:** `app/Filament/Member/Pages/Articles.php` (or resource equivalent)
- **List:** Paginated card or table layout; shows title, category, excerpt, published at
- **Filters:** Category
- **Search:** Title, content
- **View:** Full article body, author, published at, category tag

---

### 2. Browse Info Sharing Posts

- **Type:** List page
- **Class:** `app/Filament/Member/Pages/InfoSharing.php`
- **List:** Shows title, type, submitted by, approved at, like count
- **Filters:** Type
- **Search:** Title
- **Only approved posts are shown** (status = approved)

---

### 3. Create Info Sharing Post

- **Type:** Create page accessible from the info sharing list
- **Class:** `app/Filament/Member/Pages/CreateInfoSharingPost.php`
- **Access control:** Requires role permission for post creation; unauthenticated or unauthorised users see a permission error
- **Fields:** Title (required), type (`InfoSharingType` — select), body (rich text or textarea, required), attachments (optional file upload)
- **On submit:** Creates `InfoSharing` record with `status = pending`; shows confirmation message; post enters moderation queue

---

### 4. Browse and Search FAQ

- **Type:** List page with expandable answers
- **Class:** `app/Filament/Member/Pages/Faq.php`
- **Layout:** Category-grouped accordion; each category shows its FAQs collapsed by default
- **Search:** Full-text search across questions and answers; matching FAQs are highlighted or filtered in real time
- **Only active FAQs and categories are shown**

---

### 5. View Community Projects

- **Type:** List page and view page
- **Class:** `app/Filament/Member/Pages/Projects.php`
- **List:** Shows name, for type, supported badge (if `ProjectsSupported` record exists)
- **View:** Full description, attachments, for type, supported status
- **Only active projects are shown**

---

### 6. View Public Roadmap

- **Type:** List page
- **Class:** `app/Filament/Member/Pages/Roadmap.php`
- **Layout:** Status-grouped list (in-progress → planned → completed)
- **Only items with `public = true` are shown**
- **No edit access in member panel**

---

### 7. Group Newsletter

- **Type:** List page and view page scoped to the user's active group
- **Class:** `app/Filament/Member/Pages/GroupNewsletter.php`
- **Scope:** Only newsletters belonging to the user's active group are shown
- **List:** Columns — title, published date
- **View:** Full newsletter content

---

### 8. Committee Meeting Minutes

- **Type:** List page and view page scoped to the user's active group
- **Class:** `app/Filament/Member/Pages/CommitteeMinutes.php`
- **Scope:** Only minutes belonging to the user's active group are shown
- **List:** Columns — meeting date, title/subject
- **View:** Full minutes content, attached documents (downloadable)
- **Access control:** Restricted to committee member roles within the group; regular members cannot view minutes

---

## Tests Required

| Test | File | Type |
|---|---|---|
| Admin can create an article | `tests/Feature/Filament/Admin/Content/ArticleManagementTest.php` | Feature |
| Admin can edit an article | `tests/Feature/Filament/Admin/Content/ArticleManagementTest.php` | Feature |
| Admin can publish and unpublish an article | `tests/Feature/Filament/Admin/Content/ArticleManagementTest.php` | Feature |
| Admin can delete an article | `tests/Feature/Filament/Admin/Content/ArticleManagementTest.php` | Feature |
| Admin can approve an info sharing post | `tests/Feature/Filament/Admin/Content/InfoSharingModerationTest.php` | Feature |
| Admin can reject an info sharing post with a reason | `tests/Feature/Filament/Admin/Content/InfoSharingModerationTest.php` | Feature |
| Rejected post submitter receives a notification email | `tests/Feature/Filament/Admin/Content/InfoSharingModerationTest.php` | Feature |
| Admin can manage FAQ entries (CRUD) | `tests/Feature/Filament/Admin/Content/FaqManagementTest.php` | Feature |
| Admin can mark a project as supported | `tests/Feature/Filament/Admin/Content/ProjectManagementTest.php` | Feature |
| Authenticated user can browse published articles | `tests/Feature/Filament/Member/Content/ArticleBrowseTest.php` | Feature |
| Unpublished article is not visible in member panel | `tests/Feature/Filament/Member/Content/ArticleBrowseTest.php` | Feature |
| Authenticated user can browse approved info sharing posts | `tests/Feature/Filament/Member/Content/InfoSharingBrowseTest.php` | Feature |
| Pending or rejected info sharing posts are not visible in member panel | `tests/Feature/Filament/Member/Content/InfoSharingBrowseTest.php` | Feature |
| Authorised user can create an info sharing post | `tests/Feature/Filament/Member/Content/InfoSharingCreateTest.php` | Feature |
| Unauthorised user cannot create an info sharing post | `tests/Feature/Filament/Member/Content/InfoSharingCreateTest.php` | Feature |
| FAQ search returns results matching both question and answer text | `tests/Feature/Filament/Member/Content/FaqSearchTest.php` | Feature |
| Group newsletter is scoped to user's active group | `tests/Feature/Filament/Member/Content/GroupNewsletterTest.php` | Feature |
| Committee minutes are not accessible to non-committee members | `tests/Feature/Filament/Member/Content/CommitteeMinutesTest.php` | Feature |

---

## Notes & Considerations

- **Moderation queue:** New info sharing posts enter a pending state and are not visible to other members until approved. Build a moderation queue view for admins — either a dedicated page or a filter on the `InfoSharingResource` list.
- **Rich text content:** Article and FAQ bodies use a rich text editor. Sanitise HTML output on render to prevent XSS — do not trust stored HTML as safe; run it through a sanitiser at display time or restrict the editor's allowed tags.
- **Group newsletter vs articles:** Group newsletters are group-specific content created and managed at the group level, distinct from organisation-wide articles. Keep the two data models and access patterns separate.
- **Committee minutes sensitivity:** Minutes may contain sensitive member information (disciplinary matters, financials). Restrict access to committee roles only and do not include minutes content in any bulk export or search index.
- **Roadmap public flag:** The `public` flag allows the backoffice team to maintain a richer internal roadmap while only surfacing selected items to members. Default new items to `public = false` so they are never accidentally exposed.
- **Info sharing likes:** `InfoSharingLike` records are one-per-user-per-post. Enforce this at the database level (unique constraint on user_id + info_sharing_id) and at the application level.
- **POPIA:** User-generated content (info sharing posts) may include personal details submitted voluntarily. Ensure the moderation step checks for inappropriate personal data disclosure before approving posts.
