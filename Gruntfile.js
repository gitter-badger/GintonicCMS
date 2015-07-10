/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    bowerRequirejs: {
        options: {
            exclude: [
                'react',
                'jsxTransformer',
                'jsx-requirejs-plugin',
                'requirejs-text'
            ],
            transitive: true
        },
        target: {
            rjsConfig: 'assets/js/main.js'
        }
    },
    requirejs: {
      compile: {
        options: {
          appDir:"assets/tmp",
          baseUrl:"./",
          dir:"webroot/js",
          stubModules: ['jsx', 'text', 'JSXTransformer'],
          paths: {
              requireLib: '../../node_modules/requirejs/require',
          },
          modules:[{
            name: "main",
            include: "requireLib"
          }],
          noBuildTxt: true
        }
      }
    },
    copy: {
      scripts: {
        files: [
          {expand: true, cwd: './assets/js/', src: ['**'], dest: 'assets/tmp'},
        ],
      },
      vendor: {
        files: [
          {expand: true, cwd: './assets/vendor/', src: ['**'], dest: 'webroot/vendor/'},
        ],
      },
    },
    less: {
      production: {
        options: {
          paths: [
            "assets/less",
            "assets/vendor"
          ],
          compress: true,
          optimization: 0
        },
        files: {
          "webroot/css/messages.css": "assets/less/messages.less",
        }
      }
    },
    react: {
      dynamic_mappings: {
        files: [
          {
            expand: true,
            cwd: 'assets/tmp',
            src: ['**/*.jsx'],
            dest: 'assets/tmp',
            ext: '.js'
          }
        ]
      }
    },
    clean: {
        tmp: ["assets/tmp"]
    },
    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      },
      dist: {
        src: ['lib/<%= pkg.name %>.js'],
        dest: 'dist/<%= pkg.name %>.js'
      }
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: '<%= concat.dist.dest %>',
        dest: 'dist/<%= pkg.name %>.min.js'
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        browser: true,
        globals: {
          jQuery: true
        }
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      lib_test: {
        src: ['lib/**/*.js', 'test/**/*.js']
      }
    },
    qunit: {
      files: ['test/**/*.html']
    },
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      requirejs: {
        files: ["assets/js/**/*"],
        tasks: ["requirejs"],
      },
      less: {
          files: ["assets/less/*"],
          tasks: ["less"],
      },
      lib_test: {
        files: '<%= jshint.lib_test.src %>',
        tasks: ['jshint:lib_test', 'qunit']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-qunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-requirejs');
  grunt.loadNpmTasks('grunt-contrib-requirejs');
  grunt.loadNpmTasks('grunt-bower-requirejs');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-react');
  grunt.loadNpmTasks('grunt-contrib-clean');

  // Default task.
  
  grunt.registerTask('scripts', ['bowerRequirejs', 'copy:scripts','react','requirejs']);
  grunt.registerTask('default', ['scripts', 'less', 'copy:vendor']);

};
