module.exports = {
  testEnvironmentOptions: {
    customExportConditions: ["node", "node-addons", "./"],
  },
  testEnvironment: "jsdom",
  moduleFileExtensions: ["js", "json", "vue"],
  transform: {
    "^.+\\.js$": "babel-jest",
    "^.+\\.vue$": "@vue/vue3-jest",
    "^.+\\.tsx?$": "ts-jest",
  },
  roots: ["<rootDir>"],
  modulePaths: ["<rootDir>"],
  moduleDirectories: ["node_modules"],
};
