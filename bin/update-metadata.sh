#!/usr/bin/env bash

ARCHIVE_URL="https://github.com/dew-serverless/acs-metadata/releases/latest/download/php.tar.gz"
BUILD_DIR="resources/metadata"

# Ensure the directory is exists
mkdir -p $BUILD_DIR

# Download and extract the archive to the build directory
curl -sL $ARCHIVE_URL | tar -xz -C $BUILD_DIR

echo "Metadata update successfully!"
