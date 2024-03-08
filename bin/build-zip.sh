#!/bin/sh

# Set the plugin slug to "wp-ajaxify" (you can change it as needed).
PLUGIN_SLUG="wp-ajaxify"

# Get the current project path and set the build and destination paths.
PROJECT_PATH=$(pwd)
BUILD_PATH="${PROJECT_PATH}/build"
DEST_PATH="$BUILD_PATH/$PLUGIN_SLUG"

# Inform the user that the script is creating the build directory.
echo "Creating the build directory..."

# Remove the existing build directory if it exists and create a new one.
rm -rf "$BUILD_PATH"
mkdir -p "$DEST_PATH"

# Inform the user that the script is syncing files from the project directory to the build directory.
echo "Syncing project files to the build directory..."

# Use rsync to copy files from the project directory to the destination directory,
# excluding files listed in .distignore, and deleting any files in the destination
# that are not in the source directory.
rsync -rc --exclude-from="$PROJECT_PATH/.distignore" "$PROJECT_PATH/" "$DEST_PATH/" --delete --delete-excluded

# Inform the user that the script is generating a zip file.
echo "Generating a zip file..."

# Change the current working directory to the build directory.
cd "$BUILD_PATH" || exit

# Create a zip file from the contents of the plugin directory.
zip -q -r "${PLUGIN_SLUG}.zip" "$PLUGIN_SLUG/"

# Change back to the project directory.
cd "$PROJECT_PATH" || exit

# Move the generated zip file from the build directory to the project directory.
mv "$BUILD_PATH/${PLUGIN_SLUG}.zip" "$PROJECT_PATH"

# Inform the user that the zip file has been generated successfully.
echo "Zip file '${PLUGIN_SLUG}.zip' has been generated in the project directory."

# Inform the user that the build process is complete.
echo "Build process is complete!"
