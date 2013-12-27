"use strict"
module.exports = (grunt) ->
    FilesDir = "static"

    #
    # Grunt configuration:
    #
    # https://github.com/cowboy/grunt/blob/master/docs/getting_started.md
    #
    grunt.initConfig

    # Project configuration
    # ---------------------

    # specify an alternate install location for Bower
        bower:
            dir: "static/components"


    # Coffee to JS compilation
        coffee:
            scripts:
                files:
                    "static/scripts/scripts.compiled.js": "static/scripts/*.coffee"

        stylus:
            do:
                options:
                    compress: true
                    "include css": true

                files:
                    "static/styles/allstyles.compiled.css": "static/styles/style.styl"


    # generate application cache manifest
        manifest:
            dest: ""


    # default watch configuration
        watch:
            coffee:
                files: "static/scripts/*.coffee"
                tasks: ["coffee"]
                options: { livereload: true}

            stylus:
                files: ["static/styles/**/*.styl","static/styles/**/*.css"]
                tasks: ["stylus"]
                options: { livereload: true}


    grunt.registerTask "phpserver", "Runs php builtin server", ->
        require("child_process").spawn "php", ["-S", "33.33.33.100:1234", "index.php"],
            stdio: "inherit"

    grunt.registerTask "composer", "install composer depenedencies", ->
        done = this.async()
        require("child_process").exec "composer install -o", (error, stdout, stderr) ->
            grunt.log.write stdout
            console.log "exec error: " + error + " " + stderr if error isnt null
            done()

    grunt.registerTask "cap-deploy", "deploy with capistrano", ->
        done = this.async()
        require("child_process").exec "cap deploy", (error, stdout, stderr) ->
            grunt.log.write stdout
            console.log "exec error: " + error + " " + stderr if error isnt null
            done()

    grunt.registerTask "test", "runs unit tests", ->
        done = this.async()
        require("child_process").exec "protected/tests/phpunit -c protected/tests/phpunit.xml.dist", (error, stdout, stderr) ->
            grunt.log.write stdout
            console.log "exec error: " + error + " " + stderr if error isnt null
            done()

    grunt.registerTask "analyze", "run static code analysis on the code", ->
        done = this.async()
        require("child_process").exec "echo ok..", (error, stdout, stderr) ->
            grunt.log.write stdout
            console.log "exec error: " + error + " " + stderr if error isnt null
            done()

    grunt.loadNpmTasks "grunt-contrib-stylus"
    grunt.loadNpmTasks "grunt-contrib-coffee"
    grunt.loadNpmTasks "grunt-contrib-watch"
    grunt.loadNpmTasks "grunt-simple-watch"

    grunt.registerTask "deploy", ["build", "test", "analyze", "cap-deploy"]
    grunt.registerTask "build",  ['composer', "coffee", "stylus"]
    grunt.registerTask "server", ["phpserver", "build", "simple-watch"]