import React from 'react';
import { motion } from 'framer-motion';
import { Star, Quote } from 'lucide-react';

const Testimonials: React.FC = () => {
  const testimonials = [
    {
      id: '1',
      name: 'Sarah Johnson',
      role: 'Homeowner',
      company: 'Jakarta Residence',
      content: 'YA Design Studio transformed our home beyond our wildest dreams. Yousaf and Adista\'s attention to detail and creative vision made our space both beautiful and functional. The entire process was smooth and professional.',
      rating: 5,
      image: 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=150&h=150'
    },
    {
      id: '2',
      name: 'Michael Chen',
      role: 'CEO',
      company: 'Tech Innovations Ltd',
      content: 'Our office renovation was completed on time and within budget. The team created a modern workspace that boosted our team\'s productivity and morale. Highly recommend their commercial design services.',
      rating: 5,
      image: 'https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=150&h=150'
    },
    {
      id: '3',
      name: 'Priya Sharma',
      role: 'Hotel Manager',
      company: 'Bali Luxury Resort',
      content: 'The lobby design exceeded all expectations. Guests constantly compliment the beautiful blend of traditional and modern elements. YA Design Studio truly understands hospitality design.',
      rating: 5,
      image: 'https://images.pexels.com/photos/1181686/pexels-photo-1181686.jpeg?auto=compress&cs=tinysrgb&w=150&h=150'
    },
    {
      id: '4',
      name: 'David Rodriguez',
      role: 'Restaurant Owner',
      company: 'Fusion Dining',
      content: 'The restaurant design created the perfect ambiance for our concept. The acoustic solutions and lighting design work perfectly together. Our customers love the atmosphere.',
      rating: 5,
      image: 'https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&w=150&h=150'
    },
    {
      id: '5',
      name: 'Lisa Wang',
      role: 'Homeowner',
      company: 'Surabaya Villa',
      content: 'Working with Adista on our sustainable home design was incredible. She incorporated eco-friendly materials without compromising on style. Our home is both beautiful and environmentally conscious.',
      rating: 5,
      image: 'https://images.pexels.com/photos/1130626/pexels-photo-1130626.jpeg?auto=compress&cs=tinysrgb&w=150&h=150'
    },
    {
      id: '6',
      name: 'Ahmad Pratama',
      role: 'Property Developer',
      company: 'Jakarta Properties',
      content: 'YA Design Studio has been our go-to design partner for multiple projects. Their consistency in delivering high-quality designs and managing timelines is exceptional.',
      rating: 5,
      image: 'https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=150&h=150'
    }
  ];

  return (
    <section className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            What Our Clients Say
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Don't just take our word for it. Here's what our satisfied clients have to say 
            about their experience working with YA Design Studio.
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {testimonials.map((testimonial, index) => (
            <motion.div
              key={testimonial.id}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8, delay: index * 0.1 }}
              viewport={{ once: true }}
              className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300"
            >
              <div className="flex items-center mb-4">
                <img
                  src={testimonial.image}
                  alt={testimonial.name}
                  className="w-12 h-12 rounded-full object-cover mr-4"
                />
                <div>
                  <h4 className="font-semibold text-gray-900">{testimonial.name}</h4>
                  <p className="text-gray-600 text-sm">{testimonial.role}</p>
                  <p className="text-gray-500 text-xs">{testimonial.company}</p>
                </div>
              </div>

              <div className="flex items-center mb-4">
                {[...Array(testimonial.rating)].map((_, i) => (
                  <Star key={i} className="w-5 h-5 text-yellow-400 fill-current" />
                ))}
              </div>

              <div className="relative">
                <Quote className="w-8 h-8 text-amber-200 absolute -top-2 -left-2" />
                <p className="text-gray-700 leading-relaxed pl-6">
                  {testimonial.content}
                </p>
              </div>
            </motion.div>
          ))}
        </div>

        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mt-16"
        >
          <div className="bg-white rounded-2xl p-8 shadow-lg">
            <h3 className="text-2xl font-bold text-gray-900 mb-4">
              Join Our Happy Clients
            </h3>
            <p className="text-gray-600 mb-6">
              Ready to transform your space? Let's create something amazing together.
            </p>
            <button
              onClick={() => {
                const element = document.getElementById('contact');
                if (element) element.scrollIntoView({ behavior: 'smooth' });
              }}
              className="px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-full hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
            >
              Consult Now
            </button>
          </div>
        </motion.div>
      </div>
    </section>
  );
};

export default Testimonials;