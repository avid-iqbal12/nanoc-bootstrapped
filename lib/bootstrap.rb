class BootstrapFilter < Nanoc::Filter

  identifier :bootstrap

  def run(content, params={})
    template = params[:template].downcase
    file = File.basename(@item.attributes[:filename])
    # printf "\n> USING '#{template.upcase}' TEMPLATE...\n\n"
    # printf "Compiling LESS CSS Bootstrap stylesheets:\n\n"
    if file == "bootstrap.less"
      printf "\t* bootstrap.css\n"
      system "cd content/assets/less; lessc bootstrap.less > ../css/bootstrap.css"

    elsif file == "responsive.less"
      printf "\t* bootstrap-responsive.css\n"
      system "cd content/assets/less; lessc responsive.less > ../css/bootstrap-responsive.css"
    end

    if template == "starter"
      if file == "starter.less"
        printf "\t* bootstrap-starter.css\n"
        system "cd content/assets/less/templates; lessc starter.less > ../../css/bootstrap-starter.css"
      end

    elsif template == "carousel-jumbotron"

      if file == "carousel-jumbotron.less"
        printf "\t* bootstrap-carousel-jumbotron.css\n"
        system "cd content/assets/less/templates; lessc carousel-jumbotron.less > ../../css/bootstrap-carousel-jumbotron.css"

      elsif file == "bootstrap.js"
        printf "\t* bootstrap.js\n"
        # content = content + "\nSHUDJAAA"
        # puts content
        content = content + "\n//= require templates/carousel-jumbotron.js"
      end

    end
  end
end
