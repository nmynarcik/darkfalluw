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
            files:{
              'js/<%= pkg.name %>.js': ['js/src/agon.map.js','js/src/dfuw.js','js/src/crafting.js','js/jquery*.js']
            }
          }
        },
        cssmin : {
            css:{
                src: 'style.uncompressed.css',
                dest: 'style.css'
            }
        },
        uglify: {
          options: {
            // the banner is inserted at the top of the output
            banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
          },
          dist: {
            src: 'js/<%= pkg.name %>.js',
            dest: 'js/<%= pkg.name %>.min.js'
          }
        },
        jshint: {
          // define the files to lint
          files: ['gruntfile.js', 'js/src/**/*.js','data/crafting_recipes_all.json'],
          // configure JSHint (documented at http://www.jshint.com/docs/)
          options: {
              // more options here if you want to override JSHint defaults
              loopfunc: true,
              eqnull: true,
              eqeqeq: false,
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
                dest: "data/crafting_recipes_all.json"
            }
        },
        'json-minify': {
          build: {
            files: 'data/crafting_recipes_all.json'
          }
        },
        merge_data: {
            options: {
              // Task-specific options go here.
            },
            your_target: {
              src: ['data/src/*.json'],
              dest: 'data/crafting_recipes_all.json'
            }
          },
          'string-replace': {
            dist: {
              files: {
                'data/': 'data/src/*' // includes files in dir
              },
              options: {
                replacements: [{
                  pattern: /[\[\]]/g,
                  replacement: ''
                }]
              }
            }
          },
          surround: {
              options: {
                prepend: '[',
                append: ']'
              },
              files: [{
                src: 'data/crafting_recipes_all.json',
                dest: 'data/crafting_recipes_all.min.json'
              }]
            },
        watch: {
          files: ['<%= jshint.files %>','style.uncompressed.css'],
          tasks: ['jshint','cssmin']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-merge-data');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.loadNpmTasks('grunt-surround');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('json', ['merge_data','jshint']);
    grunt.registerTask('default', ['merge_data','jshint', 'concat','cssmin','uglify']);
};
