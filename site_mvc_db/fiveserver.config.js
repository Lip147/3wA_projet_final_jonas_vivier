const fs = require("fs");
const path = require("path");

function loadEnv(filePath) {
  if (!fs.existsSync(filePath)) {
    return {};
  }

  return fs.readFileSync(filePath, "utf8").split(/\r?\n/).reduce((env, line) => {
    const trimmedLine = line.trim();

    if (!trimmedLine || trimmedLine.startsWith("#") || !trimmedLine.includes("=")) {
      return env;
    }

    const separatorIndex = trimmedLine.indexOf("=");
    const key = trimmedLine.slice(0, separatorIndex).trim();
    let value = trimmedLine.slice(separatorIndex + 1).trim();

    if (
      (value.startsWith('"') && value.endsWith('"')) ||
      (value.startsWith("'") && value.endsWith("'"))
    ) {
      value = value.slice(1, -1);
    }

    env[key] = value;
    return env;
  }, {});
}

const env = loadEnv(path.join(__dirname, ".env"));

module.exports = {
  php: env.PHP_BINARY || "C:\\xampp\\php\\php.exe"
};
