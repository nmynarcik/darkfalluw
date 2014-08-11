module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
          options: {
            // define a string to put between each file in the concatenated output
            separator: ';'
          },
          dist: {
            // the files to concatenate
            src: ['js/src/**/*.js'],
            // the location of the resulting JS file
            dest: 'js/<%= pkg.name %>.js'
          }
        },
        uglify: {
          options: {
            // the banner is inserted at the top of the output
            banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
          },
          dist: {
            files: {
              'js/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>']
            }
          }
        },
        jshint: {
          // define the files to lint
          files: ['gruntfile.js', 'js/src/**/*.js','data/crafting_recipes_all.min.json'],
          // configure JSHint (documented at http://www.jshint.com/docs/)
          options: {
              // more options here if you want to override JSHint defaults
              loopfunc: true,
              eqnull: true,
            globals: {
              jQuery: true,
              console: true,
              module: true
            }
          }
        },
        "merge-json": {
            "crafting": {
                src: [ "data/src/**/*.json" ],
                dest: "data/crafting_recipes_all.min.json"
            }
        },
        'json-minify': {
          build: {
            files: 'data/crafting_recipes_all.min.json'
          }
        },
        merge_data: {
            options: {
              // Task-specific options go here.
            },
            your_target: {
              src: ['data/src/*.{json,y{,a}ml}'],
              dest: 'data/crafting_recipes_all.min.json'
            }
          },
        watch: {
          files: ['<%= jshint.files %>'],
          tasks: ['jshint']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-merge-data');

    grunt.registerTask('test', ['concat','merge_data','jshint']);
    grunt.registerTask('default', ['jshint', 'concat', 'uglify','merge_data']);
};
