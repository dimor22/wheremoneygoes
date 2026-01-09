#!/bin/bash

# Simple script to generate PWA icons from existing logo
# This requires ImageMagick (install with: brew install imagemagick)

SOURCE_IMAGE="public/images/whereMoneyGoesLogoTransparent.png"

# Check if ImageMagick is installed
if ! command -v convert &> /dev/null; then
    echo "ImageMagick is not installed. Install it with:"
    echo "  brew install imagemagick"
    echo ""
    echo "Or manually create these icon files:"
    echo "  - public/images/icon-192.png (192x192)"
    echo "  - public/images/icon-512.png (512x512)"
    exit 1
fi

echo "Generating PWA icons from $SOURCE_IMAGE..."

# Generate 192x192 icon
convert "$SOURCE_IMAGE" -resize 192x192 -gravity center -background none -extent 192x192 public/images/icon-192.png
echo "Created: public/images/icon-192.png"

# Generate 512x512 icon
convert "$SOURCE_IMAGE" -resize 512x512 -gravity center -background none -extent 512x512 public/images/icon-512.png
echo "Created: public/images/icon-512.png"

echo "Done! PWA icons created successfully."
