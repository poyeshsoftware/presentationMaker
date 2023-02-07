# Presentation Maker Platform Models & Attributes

## User

A model to represent users within the application.

### Attributes

- `id`: The primary key for the user, an auto-incrementing integer.
- `parent_id`: An unsigned big integer field to store the ID of the parent user, if it exists.
- `name`: A string to store the name of the user.
- `email`: A string to store the email of the user.
- `role`: A number with a default value of 0 to store the role of the user.
- `password`: A string to store the hashed password of the user.
- `created_at`: A timestamp field to store the creation time of the user.
- `updated_at`: A timestamp field to store the last update time of the user.

### Relationships

- `parent`: A relationship with the `User` model, indicating that a user can have a parent user.
- `projects`: A relationship with the `Project` model, indicating that a user can have many projects.

## Project

A model to represent projects within the application.

### Attributes

- `id`: The primary key for the project, an auto-incrementing integer.
- `user_id`: An unsigned big integer field to store the ID of the user that created the project.
- `name`: A string to store the name of the project.
- `slug`: A string to store the slug of the project.
- `created_at`: A timestamp field to store the creation time of the project.
- `updated_at`: A timestamp field to store the last update time of the project.

### Relationships

- `user`: A relationship with the `User` model, indicating that a project belongs to a user.
- `slideCollections`: A relationship with the `SlideCollection` model, indicating that a project can have many slide
  collections.
- `images`: A relationship with the `Image` model, indicating that a project can have many images.
- `slides`: A relationship with the `Slide` model, indicating that a project can have many slides through its slide
  collections.

## SlideCollection

A model to represent slide collections within the application.

### Attributes

- `id`: The primary key for the slide collection, an auto-incrementing integer.
- `project_id`: An unsigned big integer field to store the ID of the project that the slide collection belongs to.
- `name`: A string to store the name of the slide collection.
- `slug`: A string to store the slug of the slide collection.
- `order_num`: An unsigned big integer field to store the order number of the slide collection.
- `created_at`: A timestamp field to store the creation time of the slide collection.
- `updated_at`: A timestamp field to store the last update time of the slide collection.

### Relationships

- `project`: A relationship with the `Project` model, indicating that a slide collection belongs to a project.
- `slides`: A relationship with the `Slide` model, indicating that a slide collection can have many slides.

## Image

A model to represent images within the application.

### Attributes

- `id`: The primary key for the image, an auto-incrementing integer.
- `project_id`: An unsigned big integer field to store the ID of the project that the image belongs to.
- `parent_id`: An unsigned big integer field to store the ID of the parent image, if it exists.
- `type`: A string field to store the type of the image.
- `file_name`: A string field to store the file name of the image.
- `address`: A string field to store the address of the image.
- `width`: A small integer field to store the width of the image.
- `height`: A small integer field to store the height of the image.
- `format`: A string field to store the format of the image.
- `alt`: A string field to store the alt text of the image.
- `created_at`: A timestamp field to store the creation time of the image.
- `updated_at`: A timestamp field to store the last update time of the image.

### Relationships

- `project`: A relationship with the `Project` model, indicating that an image belongs to a project.
- `parent`: A relationship with the `Image` model, indicating that an image can have a parent image.
- `children`: A relationship with the `Image` model, indicating that an image can have many child images.

## Slide

A model to represent slides within the application.

### Attributes

- `id`: The primary key for the slide, an auto-incrementing integer.
- `slide_collection_id`: An unsigned big integer field to store the ID of the slide collection that the slide belongs
  to.
- `parent_id`: An unsigned big integer field to store the ID of the parent slide, if it exists.
- `image_id`: An unsigned big integer field to store the ID of the image that the slide has.
- `slide_type`: A tiny integer field to store the type of the slide.
- `order_num`: An unsigned big integer field to store the order number of the slide.
- `name`: A string to store the name of the slide.
- `slug`: A string to store the slug of the slide.
- `created_at`: A timestamp field to store the creation time of the slide.
- `updated_at`: A timestamp field to store the last update time of the slide.

### Relationships

- `slideCollection`: A relationship with the `SlideCollection` model, indicating that a slide belongs to a slide
  collection.
- `image`: A relationship with the `Image` model, indicating that a slide has an image.
- `parent`: A relationship with the `Slide` model, indicating that a slide can have a parent slide.
- `buttons`: A relationship with the `Button` model, indicating that a slide can have many buttons.
- `references`: A relationship with the `Reference` model, indicating that a slide can have many references.
- `slides`: A relationship with the `Slide` model, indicating that a slide can have many child slides.

## Reference

A model to represent references within the application.

### Attributes

- `id`: The primary key for the reference, an auto-incrementing integer.
- `slide_id`: An unsigned big integer field to store the ID of the slide that the reference belongs to.
- `order_num`: An unsigned big integer field to store the order number of the reference.
- `type`: An unsigned tiny integer field to store the type of the reference.
- `prefix`: A string to store the prefix of the reference.
- `text`: A string to store the text of the reference.
- `created_at`: A timestamp field to store the creation time of the reference.
- `updated_at`: A timestamp field to store the last update time of the reference.

### Relationships

- `slide`: A relationship with the `Slide` model, indicating that a reference belongs to a slide.

## Button

A model to represent buttons within the application.

### Attributes

- `id`: The primary key for the button, an auto-incrementing integer.
- `slide_id`: An unsigned big integer field to store the ID of the slide that the button belongs to.
- `left`: An unsigned medium integer field to store the left position of the button.
- `top`: An unsigned medium integer field to store the top position of the button.
- `width`: An unsigned medium integer field to store the width of the button.
- `height`: An unsigned medium integer field to store the height of the button.
- `type`: An unsigned tiny integer field to store the type of the button.
- `link_slide_id`: An unsigned big integer field to store the ID of the slide that the button links to, if it exists.
- `created_at`: A timestamp field to store the creation time of the button.
- `updated_at`: A timestamp field to store the last update time of the button.

### Relationships

- `slide`: A relationship with the `Slide` model, indicating that a button belongs to a slide.
- `link_slide`: A relationship with the `Slide` model, indicating that a button can be linked to a slide if
  the `link_slide_id` field is not null.

## Document

A Document belongs to a Project.

### Fields

- `id`: bigIncrements
- `name`: string
- `format`: string
- `project_id`: unsignedBigInteger
- `timestamps`: timestamps

### Relationships

- `project`: a Document belongs to a Project.

## Menu

A Menu belongs to a Project.

### Fields

- `id`: bigIncrements
- `name`: string
- `project_id`: unsignedBigInteger
- `type`: unsignedTinyInteger
- `timestamps`: timestamps

### Relationships

- `project`: a Menu belongs to a Project.

## MenuCategory

A MenuCategory belongs to a Menu.

### Fields

- `id`: bigIncrements
- `name`: string
- `menu_id`: unsignedBigInteger
- `order_num`: unsignedBigInteger
- `timestamps`: timestamps

### Relationships

- `menu`: a MenuCategory belongs to a Menu.

## MenuItem

A MenuItem belongs to a MenuCategory.

### Fields

- `id`: bigIncrements
- `name`: string
- `menu_category_id`: unsignedBigInteger
- `order_num`: unsignedBigInteger
- `timestamps`: timestamps

### Relationships

- `menuCategory`: a MenuItem belongs to a MenuCategory.




