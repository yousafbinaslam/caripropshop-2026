import React from 'react';
import { motion } from 'framer-motion';
import { Link, useNavigate } from 'react-router-dom';
import { Home, Building, Palette, Lightbulb, Ruler, Wrench } from 'lucide-react';

const Services: React.FC = () => {
  const navigate = useNavigate();

  const handleServiceClick = (link: string) => {
    if (link.startsWith('/')) {
      navigate(link);
      window.scrollTo(0, 0);
    } else if (link.startsWith('#')) {
      const element = document.getElementById(link.substring(1));
      if (element) element.scrollIntoView({ behavior: 'smooth' });
    }
  };

  const services = [
    {
      icon: Home,
      title: 'Residential Design',
      description: 'Complete home interior design from concept to completion',
      features: ['Space Planning', 'Furniture Selection', 'Color Consultation', 'Lighting Design'],
      pricing: 'Consult Now',
      link: '/residential-design'
    },
    {
      icon: Building,
      title: 'Commercial Design',
      description: 'Professional office and retail space design solutions',
      features: ['Office Layout', 'Brand Integration', 'Ergonomic Solutions', 'Productivity Focus'],
      pricing: 'Consult Now',
      link: '/commercial-design'
    },
    {
      icon: Palette,
      title: 'Design Consultation',
      description: 'Expert advice and guidance for your design projects',
      features: ['Design Review', 'Material Selection', 'Color Schemes', 'Style Direction'],
      pricing: 'Consult Now',
      link: '/design-consultation'
    },
    {
      icon: Lightbulb,
      title: 'Lighting Design',
      description: 'Comprehensive lighting solutions for any space',
      features: ['Ambient Lighting', 'Task Lighting', 'Accent Lighting', 'Smart Controls'],
      pricing: 'Consult Now',
      link: '/lighting-design'
    },
    {
      icon: Ruler,
      title: 'Space Planning',
      description: 'Optimize your space layout for maximum functionality',
      features: ['Floor Plans', 'Traffic Flow', 'Furniture Layout', '3D Visualization'],
      pricing: 'Consult Now',
      link: '/space-planning'
    },
    {
      icon: Wrench,
      title: 'Project Management',
      description: 'Full project oversight from start to finish',
      features: ['Timeline Management', 'Vendor Coordination', 'Quality Control', 'Budget Management'],
      pricing: 'Consult Now',
      link: '/project-management'
    }
  ];

  return (
    <section id="services" className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Our Design Services
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Comprehensive interior design solutions tailored to your unique needs and vision. 
            From residential homes to commercial spaces, we bring expertise to every project.
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {services.map((service, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8, delay: index * 0.1 }}
              viewport={{ once: true }}
              className="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300 group hover:bg-white cursor-pointer"
              onClick={() => {
                handleServiceClick(service.link);
              }}
            >
              <div className="flex items-center mb-6">
                <div className="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                  <service.icon className="w-6 h-6 text-white" />
                </div>
                <h3 className="text-xl font-bold text-gray-900">{service.title}</h3>
              </div>

              <p className="text-gray-600 mb-6">{service.description}</p>

              <div className="space-y-2 mb-6">
                {service.features.map((feature, featureIndex) => (
                  <div key={featureIndex} className="flex items-center text-gray-700">
                    <div className="w-2 h-2 bg-amber-500 rounded-full mr-3" />
                    <span className="text-sm">{feature}</span>
                  </div>
                ))}
              </div>

              <div className="border-t pt-4">
                <p className="text-lg font-semibold text-amber-600">{service.pricing}</p>
                {service.link.startsWith('/') && (
                  <p className="text-sm text-blue-600 mt-2 font-medium">Click to get a custom quote →</p>
                )}
              </div>
            </motion.div>
          ))}
        </div>

        {/* Consultation Notice */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mt-12"
        >
          <div className="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-8 border border-amber-200">
            <h3 className="text-2xl font-bold text-gray-900 mb-4">Consultation Information</h3>
            <div className="bg-white rounded-lg p-6 mb-6 border-l-4 border-amber-500">
              <p className="text-lg font-semibold text-gray-900 mb-2">
                📋 Get Your Custom Quote Today
              </p>
              <p className="text-gray-700">
                Our expert design services are customized to your specific needs and budget. 
                Contact us for a personalized consultation and detailed quote for your project.
              </p>
            </div>
            <p className="text-gray-600 mb-6">
              Every project is unique. We provide detailed quotes based on your specific requirements, 
              space size, complexity, and timeline to ensure transparent and fair pricing.
            </p>
            <button
              onClick={() => {
                const element = document.getElementById('contact');
                if (element) element.scrollIntoView({ behavior: 'smooth' });
              }}
              className="px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-full hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
            >
              Get Your Custom Quote
            </button>
          </div>
        </motion.div>
      </div>
    </section>
  );
};

export default Services;