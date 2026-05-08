# Feature: Content & Community

> Module: Content & Community
> Panel(s): Admin (backoffice), Member
> Status: Planned — Needs Human Review
> Phase: 10 — Content & Community

---

## Overview

The platform includes several community facing features for sharing news, resources, and information across the organisation. The backoffice panel provides full content management and moderation tools. The member panel provides a read focused experience for members, with limited creation capabilities for authorised users.

---

## Backoffice (Admin) Requirements

### Articles Management

- Administrators can create, edit, publish, unpublish, archive, and delete articles.
- Each article has a title, category, body (rich text), status (draft, published, or archived), publication date (which supports scheduling), a featured image, a short excerpt, and an author.
- Title and body are required. A publication date is required when the status is set to published.
- The author is automatically set to the current administrator but can be overridden.
- Articles can be filtered by category, status, and published date range. Searchable by title, body excerpt, and author name.

### Info Sharing Moderation

- Administrators review community submitted information sharing posts.
- Posts are listed with title, type, submitter, status (pending, approved, or rejected), and submission date.
- Filterable by type, status, and submitted date range. Searchable by title and submitter name.
- Administrators can approve or reject posts individually or in bulk.
- Rejection requires a reason. When a post is rejected, the submitter is notified by email.
- Only approved posts are visible to members.

### FAQ Management

- Administrators can create, edit, reorder, and delete FAQ entries.
- Each FAQ has a question, answer (rich text), category, active toggle, and sort order.
- Question, answer, and category are all required.
- FAQs can be reordered via drag and drop within each category.
- FAQ categories can be created, renamed, reordered, and deleted. A category cannot be deleted if it contains FAQ entries.

### Projects Management

- Administrators can create, edit, and manage community project records.
- Each project has a name, description (rich text), beneficiary type (e.g. environment, community, youth), a supported toggle, an active toggle, and optional images or attachments.
- Projects can be marked as officially supported or unsupported by the organisation.
- Filterable by supported status, beneficiary type, and active status. Searchable by name and description.

### Roadmap Management

- Administrators can create and manage public roadmap items.
- Each item has a title, description, status (planned, in progress, completed, or cancelled), an optional target date, and a public visibility toggle.
- Only items marked as public are visible to members.
- New items default to not public, so they are never accidentally exposed.

---

## Member Panel Requirements

### Access Rules

- All read only content pages (articles, FAQs, projects, roadmap) are accessible to any authenticated member.
- Creating info sharing posts requires an explicit role permission. Not all members can create posts by default.
- Group newsletters and committee meeting minutes are scoped to the user's active group only.

### Browse and Read Articles

- Members can browse a paginated list of published articles showing title, category, excerpt, and publication date.
- Filterable by category and searchable by title and content.
- Members can view the full article body, author, publication date, and category.
- Only published articles are visible. Draft and archived articles are not shown.

### Browse Info Sharing Posts

- Members can browse approved info sharing posts, showing title, type, submitter, approval date, and like count.
- Filterable by type and searchable by title.
- Only approved posts are visible. Pending and rejected posts are not shown.

### Create Info Sharing Post

- Authorised members can create new info sharing posts with a title, type, body, and optional attachments.
- Title and body are required.
- Submitted posts enter a pending moderation queue and are not visible to other members until approved by an administrator.
- Unauthorised members see a permission error when attempting to create a post.

### Browse and Search FAQ

- Members can browse FAQs organised by category in an accordion layout, with each category's entries collapsed by default.
- Full text search across questions and answers, with matching entries highlighted or filtered in real time.
- Only active FAQs and categories are shown.

### View Community Projects

- Members can browse and view active community projects, showing name, beneficiary type, and whether the project is officially supported.
- The full project view includes the description, attachments, beneficiary type, and supported status.
- Only active projects are shown.

### View Public Roadmap

- Members can view roadmap items grouped by status (in progress, planned, completed).
- Only items marked as public are visible.
- Members cannot edit roadmap items.

### Group Newsletter

- Members can browse and read newsletters belonging to their active group.
- The list shows each newsletter's title and published date.
- Only newsletters from the user's own group are accessible.

### Committee Meeting Minutes

- Committee members can browse and read meeting minutes for their active group.
- The list shows meeting date and subject.
- The full view includes the minutes content and downloadable attached documents.
- Access is restricted to users with committee member roles within the group. Regular members cannot view minutes.

---

## Business Rules and Constraints

- New info sharing posts enter a pending state and are not visible to other members until an administrator approves them.
- Rich text content (articles and FAQ answers) must be sanitised on display to prevent cross site scripting. Stored HTML should not be trusted as safe.
- Group newsletters are group specific content, distinct from organisation wide articles. The two content types are managed and accessed separately.
- Committee meeting minutes may contain sensitive member information (disciplinary matters, financials). Access must be restricted to committee roles only, and minutes content must not be included in bulk exports or search indexes.
- Each member can like an info sharing post only once. This is enforced both at the application level and at the database level with a unique constraint.
- POPIA compliance: user generated content (info sharing posts) may include personal details submitted voluntarily. The moderation step must check for inappropriate personal data disclosure before approving posts.
