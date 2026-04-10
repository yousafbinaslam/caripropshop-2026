import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { useParams, Link } from 'react-router-dom';
import { ArrowLeft, Palette, Home, Lightbulb, Star, Heart, Phone, Mail, CheckCircle, Camera, Sofa, Ruler, Award } from 'lucide-react';

interface StyleDetailProps {}

const StyleDetail: React.FC<StyleDetailProps> = () => {
  const { styleId } = useParams<{ styleId: string }>();
  const [activeImageIndex, setActiveImageIndex] = useState(0);
  const [activeRoom, setActiveRoom] = useState('living-room');

  // Comprehensive style data with unique images for each style
  const styleData = {
    'modern-minimalist': {
      name: 'Modern Minimalist',
      description: 'Clean lines, uncluttered spaces, and a focus on functionality with sophisticated simplicity.',
      longDescription: 'Modern Minimalist design embodies the philosophy that "less is more." This style emphasizes clean geometric lines, uncluttered spaces, and a carefully curated selection of furniture and decor. Every element serves a purpose, creating spaces that are both beautiful and highly functional. The color palette typically features neutral tones with occasional bold accents, while natural light plays a crucial role in highlighting the architectural elements and creating an airy, open atmosphere.',
      keyCharacteristics: [
        'Clean geometric lines and simple forms',
        'Neutral color schemes with strategic accents',
        'Functional furniture with hidden storage',
        'Open floor plans and uncluttered spaces',
        'Natural light emphasis and large windows',
        'High-quality materials in their natural state',
        'Minimal decorative elements with maximum impact',
        'Integration of technology and smart home features'
      ],
      colorPalette: [
        { color: '#FFFFFF', name: 'Pure White', usage: 'Primary walls and ceilings' },
        { color: '#F5F5F5', name: 'Soft Gray', usage: 'Secondary surfaces and furniture' },
        { color: '#E8E8E8', name: 'Light Gray', usage: 'Accent walls and textiles' },
        { color: '#2C2C2C', name: 'Charcoal', usage: 'Statement pieces and contrast' },
        { color: '#8B8B8B', name: 'Medium Gray', usage: 'Hardware and accessories' }
      ],
      materials: [
        { material: 'Glass', description: 'Floor-to-ceiling windows, glass tables, and transparent elements' },
        { material: 'Steel', description: 'Structural elements, furniture frames, and architectural details' },
        { material: 'Concrete', description: 'Polished floors, countertops, and accent walls' },
        { material: 'Natural Wood', description: 'Oak, walnut, or teak for warmth and texture' },
        { material: 'Marble', description: 'Countertops, bathroom surfaces, and statement pieces' }
      ],
      priceRange: '$15,000 - $75,000',
      gallery: [
        'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1648776/pexels-photo-1648776.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1571468/pexels-photo-1571468.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featuredProducts: [
        {
          name: 'Milano Sectional Sofa',
          price: 'Consult Now',
          description: 'Italian leather sectional with clean lines and modular design',
          image: 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Zen Coffee Table',
          price: 'Consult Now',
          description: 'Glass top with steel base, perfect for minimalist living rooms',
          image: 'https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Nordic Dining Set',
          price: 'Consult Now',
          description: 'Oak table with steel legs and matching chairs',
          image: 'https://images.pexels.com/photos/1648776/pexels-photo-1648776.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Minimalist Bed Frame',
          price: 'Consult Now',
          description: 'Platform bed with integrated nightstands',
          image: 'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create an open, airy space with carefully selected furniture pieces',
          tips: [
            'Choose a neutral sectional sofa as the focal point',
            'Add a glass or marble coffee table for visual lightness',
            'Use built-in storage to maintain clean lines',
            'Incorporate one statement art piece for visual interest',
            'Ensure ample natural light with minimal window treatments'
          ],
          products: ['Milano Sectional Sofa', 'Zen Coffee Table']
        },
        'bedroom': {
          title: 'Bedroom',
          description: 'Design a serene retreat with minimal furniture and maximum comfort',
          tips: [
            'Select a platform bed with clean geometric lines',
            'Use built-in or floating nightstands',
            'Choose blackout curtains in neutral tones',
            'Add texture with high-quality bedding',
            'Keep surfaces clear and uncluttered'
          ],
          products: ['Minimalist Bed Frame']
        },
        'kitchen': {
          title: 'Kitchen',
          description: 'Combine functionality with sleek aesthetics',
          tips: [
            'Install handleless cabinets for seamless appearance',
            'Choose quartz or marble countertops',
            'Use integrated appliances for clean lines',
            'Add pendant lighting with geometric shapes',
            'Maintain clear countertops with hidden storage'
          ],
          products: ['Nordic Dining Set']
        }
      }
    },
    'contemporary-luxury': {
      name: 'Contemporary Luxury',
      description: 'Sophisticated elegance with premium materials, bold statements, and refined comfort.',
      longDescription: 'Contemporary Luxury design represents the pinnacle of modern sophistication, combining cutting-edge design with the finest materials and craftsmanship. This style features bold architectural elements, premium finishes, and carefully curated art pieces that create spaces of unparalleled elegance and comfort.',
      keyCharacteristics: [
        'Premium materials and finishes throughout',
        'Bold architectural statements and features',
        'Sophisticated color schemes with metallic accents',
        'Statement lighting and custom fixtures',
        'Luxurious textures and high-end fabrics',
        'Custom millwork and built-in elements',
        'Art collection integration and gallery walls',
        'Smart home technology seamlessly integrated'
      ],
      colorPalette: [
        { color: '#1A1A1A', name: 'Charcoal Black', usage: 'Accent walls and statement pieces' },
        { color: '#D4AF37', name: 'Champagne Gold', usage: 'Hardware and metallic accents' },
        { color: '#FFFFFF', name: 'Crisp White', usage: 'Primary surfaces and trim' },
        { color: '#8B4513', name: 'Rich Bronze', usage: 'Furniture and decorative elements' },
        { color: '#C0C0C0', name: 'Platinum Silver', usage: 'Fixtures and accessories' }
      ],
      materials: [
        { material: 'Carrara Marble', description: 'Premium Italian marble for countertops and feature walls' },
        { material: 'Velvet Upholstery', description: 'Luxurious velvet fabrics in rich jewel tones' },
        { material: 'Brass Hardware', description: 'Custom brass fixtures and architectural details' },
        { material: 'Italian Leather', description: 'Hand-selected leather for furniture and accents' },
        { material: 'Crystal Elements', description: 'Baccarat crystal lighting and decorative pieces' }
      ],
      priceRange: '$50,000 - $200,000',
      gallery: [
        'https://images.pexels.com/photos/2029667/pexels-photo-2029667.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/380768/pexels-photo-380768.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/2062426/pexels-photo-2062426.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featuredProducts: [
        {
          name: 'Luxury Velvet Sectional',
          price: 'Consult Now',
          description: 'Custom velvet sectional with brass nail head trim',
          image: 'https://images.pexels.com/photos/2029667/pexels-photo-2029667.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Marble Dining Table',
          price: 'Consult Now',
          description: 'Carrara marble table with brass pedestal base',
          image: 'https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Crystal Chandelier',
          price: 'Consult Now',
          description: 'Baccarat crystal chandelier with LED integration',
          image: 'https://images.pexels.com/photos/380768/pexels-photo-380768.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Executive Desk',
          price: 'Consult Now',
          description: 'Walnut executive desk with leather inlay top',
          image: 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create a sophisticated entertaining space with premium materials',
          tips: [
            'Invest in a statement velvet sectional as the centerpiece',
            'Add a marble or onyx coffee table for luxury appeal',
            'Install custom millwork for built-in bar and storage',
            'Use layered lighting with crystal chandeliers and accent lamps',
            'Incorporate original artwork and sculpture collections'
          ],
          products: ['Luxury Velvet Sectional', 'Crystal Chandelier']
        },
        'dining-room': {
          title: 'Dining Room',
          description: 'Design an elegant space for formal entertaining',
          tips: [
            'Choose a marble dining table as the focal point',
            'Select upholstered dining chairs in luxury fabrics',
            'Install a statement chandelier for dramatic lighting',
            'Add a custom wine storage and serving area',
            'Use rich window treatments in silk or velvet'
          ],
          products: ['Marble Dining Table', 'Crystal Chandelier']
        },
        'home-office': {
          title: 'Home Office',
          description: 'Create a sophisticated workspace that inspires productivity',
          tips: [
            'Invest in a premium executive desk with leather details',
            'Add custom built-in bookcases and storage',
            'Use rich wood paneling or luxury wallpaper',
            'Install professional-grade lighting for work tasks',
            'Include a seating area for client meetings'
          ],
          products: ['Executive Desk']
        }
      }
    },
    'traditional-classic': {
      name: 'Traditional Classic',
      description: 'Timeless elegance with rich fabrics, warm colors, and classic furniture pieces.',
      longDescription: 'Traditional Classic design draws inspiration from European and American design traditions, featuring rich fabrics, warm color palettes, and time-honored furniture pieces. This style creates spaces that feel established and refined, with layers of texture and pattern that tell a story of heritage and sophistication.',
      keyCharacteristics: [
        'Rich fabrics and luxurious textiles',
        'Warm, inviting color palettes',
        'Classic furniture with ornate details',
        'Symmetrical layouts and formal arrangements',
        'Layered patterns and textures',
        'Antique and heirloom pieces integration',
        'Traditional architectural elements',
        'Formal window treatments and drapery'
      ],
      colorPalette: [
        { color: '#8B4513', name: 'Rich Mahogany', usage: 'Wood furniture and trim' },
        { color: '#DAA520', name: 'Golden Rod', usage: 'Accent colors and metallics' },
        { color: '#F5DEB3', name: 'Warm Wheat', usage: 'Wall colors and neutral base' },
        { color: '#2F4F4F', name: 'Dark Slate', usage: 'Upholstery and dramatic accents' },
        { color: '#800000', name: 'Deep Burgundy', usage: 'Rich fabric accents and rugs' }
      ],
      materials: [
        { material: 'Mahogany Wood', description: 'Rich hardwood for furniture and architectural details' },
        { material: 'Silk Fabrics', description: 'Luxurious silk for drapery and upholstery' },
        { material: 'Wool Carpets', description: 'Hand-knotted Persian and Oriental rugs' },
        { material: 'Brass Fixtures', description: 'Traditional brass hardware and lighting' },
        { material: 'Fine Porcelain', description: 'Decorative porcelain and ceramic accessories' }
      ],
      priceRange: '$25,000 - $120,000',
      gallery: [
        'https://images.pexels.com/photos/1350789/pexels-photo-1350789.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/271639/pexels-photo-271639.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/941861/pexels-photo-941861.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featuredProducts: [
        {
          name: 'Chesterfield Sofa',
          price: 'Consult Now',
          description: 'Classic leather Chesterfield with button tufting',
          image: 'https://images.pexels.com/photos/1350789/pexels-photo-1350789.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Mahogany Dining Set',
          price: 'Consult Now',
          description: 'Traditional mahogany table with upholstered chairs',
          image: 'https://images.pexels.com/photos/271639/pexels-photo-271639.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Persian Area Rug',
          price: 'Consult Now',
          description: 'Hand-knotted Persian rug with traditional patterns',
          image: 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Grandfather Clock',
          price: 'Consult Now',
          description: 'Traditional mahogany grandfather clock with chimes',
          image: 'https://images.pexels.com/photos/941861/pexels-photo-941861.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create a formal yet comfortable gathering space',
          tips: [
            'Arrange furniture in conversational groupings',
            'Layer Persian rugs over hardwood floors',
            'Use rich fabrics for window treatments',
            'Display family heirlooms and antiques',
            'Add table lamps for warm ambient lighting'
          ],
          products: ['Chesterfield Sofa', 'Persian Area Rug']
        },
        'dining-room': {
          title: 'Dining Room',
          description: 'Design a formal dining space for special occasions',
          tips: [
            'Center the room around a mahogany dining table',
            'Use matching chairs with rich upholstery',
            'Install a traditional crystal chandelier',
            'Add a sideboard for serving and storage',
            'Display fine china and silver collections'
          ],
          products: ['Mahogany Dining Set']
        },
        'study': {
          title: 'Study',
          description: 'Create a scholarly retreat with classic furnishings',
          tips: [
            'Install floor-to-ceiling built-in bookcases',
            'Add a traditional leather desk chair',
            'Use warm wood tones throughout',
            'Include a grandfather clock for timeless appeal',
            'Display leather-bound books and collectibles'
          ],
          products: ['Grandfather Clock']
        }
      }
    },
    'art-deco-glamour': {
      name: 'Art Deco Glamour',
      description: 'Bold geometric patterns, metallic accents, and luxurious materials creating dramatic sophistication.',
      longDescription: 'Art Deco Glamour captures the opulent spirit of the 1920s and 1930s, featuring bold geometric patterns, rich metallic accents, and luxurious materials. This style creates dramatic, sophisticated spaces that celebrate craftsmanship and artistic expression with a sense of theatrical grandeur.',
      keyCharacteristics: [
        'Bold geometric patterns and motifs',
        'Rich metallic accents in gold and silver',
        'Dramatic color contrasts and schemes',
        'Luxurious materials and finishes',
        'Sunburst and fan-shaped design elements',
        'Stepped and angular architectural details',
        'Mirrored surfaces and reflective elements',
        'Statement lighting with dramatic flair'
      ],
      colorPalette: [
        { color: '#000000', name: 'Jet Black', usage: 'Dramatic contrast and base color' },
        { color: '#FFD700', name: 'Pure Gold', usage: 'Metallic accents and highlights' },
        { color: '#C0C0C0', name: 'Silver Chrome', usage: 'Hardware and fixtures' },
        { color: '#800080', name: 'Royal Purple', usage: 'Luxurious fabric accents' },
        { color: '#FF6347', name: 'Coral Red', usage: 'Bold accent and statement pieces' }
      ],
      materials: [
        { material: 'Gold Leaf', description: 'Genuine gold leaf for decorative accents and frames' },
        { material: 'Black Marble', description: 'Dramatic black marble for surfaces and features' },
        { material: 'Velvet Upholstery', description: 'Rich velvet in jewel tones for seating' },
        { material: 'Mirrored Glass', description: 'Antiqued mirrors and reflective surfaces' },
        { material: 'Chrome Details', description: 'Polished chrome for hardware and accents' }
      ],
      priceRange: '$40,000 - $180,000',
      gallery: [
        'https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1181406/pexels-photo-1181406.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1648771/pexels-photo-1648771.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/2062426/pexels-photo-2062426.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featuredProducts: [
        {
          name: 'Art Deco Bar Cart',
          price: 'Consult Now',
          description: 'Mirrored bar cart with gold leaf accents',
          image: 'https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Sunburst Mirror',
          price: 'Consult Now',
          description: 'Large gold leaf sunburst mirror statement piece',
          image: 'https://images.pexels.com/photos/1181406/pexels-photo-1181406.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Velvet Armchair',
          price: 'Consult Now',
          description: 'Purple velvet armchair with chrome legs',
          image: 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Geometric Console',
          price: 'Consult Now',
          description: 'Black marble console with geometric base',
          image: 'https://images.pexels.com/photos/1648771/pexels-photo-1648771.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create a glamorous entertaining space with dramatic flair',
          tips: [
            'Use bold geometric patterns in rugs and wallpaper',
            'Add metallic accents through lighting and accessories',
            'Include mirrored furniture for reflective glamour',
            'Choose rich velvet upholstery in jewel tones',
            'Install dramatic lighting with sunburst designs'
          ],
          products: ['Velvet Armchair', 'Sunburst Mirror']
        },
        'dining-room': {
          title: 'Dining Room',
          description: 'Design a sophisticated space for elegant entertaining',
          tips: [
            'Center the room around a dramatic dining table',
            'Use a statement chandelier with geometric design',
            'Add a mirrored sideboard for serving',
            'Include bold artwork with Art Deco motifs',
            'Use rich fabrics for window treatments'
          ],
          products: ['Geometric Console']
        },
        'bar-area': {
          title: 'Bar Area',
          description: 'Create a glamorous cocktail space',
          tips: [
            'Install a mirrored bar cart as the centerpiece',
            'Use black and gold color scheme throughout',
            'Add geometric bar stools with metallic accents',
            'Include vintage cocktail accessories',
            'Install dramatic accent lighting'
          ],
          products: ['Art Deco Bar Cart']
        }
      }
    },
    'scandinavian-chic': {
      name: 'Scandinavian Chic',
      description: 'Light woods, cozy textures, and hygge comfort with functional Nordic design principles.',
      longDescription: 'Scandinavian Chic embodies the Nordic philosophy of hygge, creating spaces that prioritize comfort, functionality, and connection with nature. This style features light wood tones, cozy textiles, and a minimalist approach that emphasizes quality over quantity, resulting in serene and livable spaces.',
      keyCharacteristics: [
        'Light wood tones and natural materials',
        'Cozy textiles and layered textures',
        'Functional design with hidden storage',
        'Natural elements and plant integration',
        'Hygge comfort and livability focus',
        'Neutral color palettes with soft accents',
        'Handcrafted and artisanal pieces',
        'Sustainable and eco-friendly materials'
      ],
      colorPalette: [
        { color: '#FFFFFF', name: 'Snow White', usage: 'Primary walls and ceilings' },
        { color: '#F0F0F0', name: 'Soft Gray', usage: 'Secondary surfaces and textiles' },
        { color: '#D2B48C', name: 'Natural Tan', usage: 'Wood tones and warm accents' },
        { color: '#708090', name: 'Slate Blue', usage: 'Soft accent colors' },
        { color: '#98FB98', name: 'Sage Green', usage: 'Natural and plant-inspired accents' }
      ],
      materials: [
        { material: 'Pine Wood', description: 'Light Scandinavian pine for furniture and flooring' },
        { material: 'Wool Textiles', description: 'Natural wool for throws, rugs, and upholstery' },
        { material: 'Linen Fabrics', description: 'Organic linen for curtains and bedding' },
        { material: 'Ceramic Pottery', description: 'Handmade ceramics for decorative accents' },
        { material: 'Sheepskin Rugs', description: 'Natural sheepskin for texture and warmth' }
      ],
      priceRange: '$12,000 - $60,000',
      gallery: [
        'https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1648776/pexels-photo-1648776.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featuredProducts: [
        {
          name: 'Nordic Sofa',
          price: 'Consult Now',
          description: 'Light oak frame sofa with linen cushions',
          image: 'https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Hygge Coffee Table',
          price: 'Consult Now',
          description: 'Round pine coffee table with storage',
          image: 'https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Wool Throw Collection',
          price: 'Consult Now',
          description: 'Set of three wool throws in neutral tones',
          image: 'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Ceramic Pendant Light',
          price: 'Consult Now',
          description: 'Handmade ceramic pendant with cord',
          image: 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create a cozy gathering space that embodies hygge',
          tips: [
            'Choose a comfortable sofa with natural fabrics',
            'Layer wool throws and sheepskin rugs for texture',
            'Add plants for natural elements and air purification',
            'Use warm lighting with multiple sources',
            'Include handmade ceramics and wooden accessories'
          ],
          products: ['Nordic Sofa', 'Hygge Coffee Table', 'Wool Throw Collection']
        },
        'bedroom': {
          title: 'Bedroom',
          description: 'Design a peaceful retreat for rest and relaxation',
          tips: [
            'Use light wood furniture with clean lines',
            'Layer organic cotton and linen bedding',
            'Add a reading nook with comfortable seating',
            'Include natural elements like plants or stones',
            'Use soft, warm lighting for ambiance'
          ],
          products: ['Wool Throw Collection']
        },
        'kitchen': {
          title: 'Kitchen',
          description: 'Create a functional space for cooking and gathering',
          tips: [
            'Use light wood cabinets with simple hardware',
            'Add open shelving for displaying ceramics',
            'Include a dining area with natural wood table',
            'Use pendant lighting over work areas',
            'Display fresh herbs and plants'
          ],
          products: ['Ceramic Pendant Light']
        }
      }
    }
  };

  const style = styleData[styleId as keyof typeof styleData];

  if (!style) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-2xl font-bold text-gray-900 mb-4">Style Not Found</h1>
          <Link to="/" className="text-amber-600 hover:text-amber-700">
            Return to Home
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-white shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <div className="flex items-center justify-between">
            <Link
              to="/"
              className="flex items-center text-gray-600 hover:text-amber-600 transition-colors"
            >
              <ArrowLeft className="w-5 h-5 mr-2" />
              Back to Collection
            </Link>
            <div className="flex items-center space-x-4">
              <div className="flex items-center text-amber-600">
                <Star className="w-5 h-5 mr-1" />
                <span className="text-sm font-medium">Premium Collection</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {/* Hero Section */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="grid lg:grid-cols-2 gap-12 mb-16"
        >
          {/* Image Gallery */}
          <div>
            <div className="relative mb-4">
              <img
                src={style.gallery[activeImageIndex]}
                alt={style.name}
                className="w-full h-96 object-cover rounded-2xl shadow-lg"
              />
              <div className="absolute top-4 right-4">
                <div className="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium">
                  {activeImageIndex + 1} / {style.gallery.length}
                </div>
              </div>
            </div>
            <div className="grid grid-cols-5 gap-2">
              {style.gallery.map((image, index) => (
                <button
                  key={index}
                  onClick={() => setActiveImageIndex(index)}
                  className={`relative overflow-hidden rounded-lg ${
                    index === activeImageIndex ? 'ring-2 ring-amber-500' : ''
                  }`}
                >
                  <img
                    src={image}
                    alt={`${style.name} ${index + 1}`}
                    className="w-full h-20 object-cover hover:scale-110 transition-transform"
                  />
                </button>
              ))}
            </div>
          </div>

          {/* Style Information */}
          <div>
            <div className="flex items-center mb-4">
              <div className="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center mr-4">
                <Palette className="w-6 h-6 text-white" />
              </div>
              <div>
                <h1 className="text-3xl font-bold text-gray-900">{style.name}</h1>
                <p className="text-amber-600 font-medium">Premium Luxury Collection</p>
              </div>
            </div>

            <p className="text-gray-600 text-lg mb-6">{style.description}</p>
            <p className="text-gray-700 mb-8">{style.longDescription}</p>

            {/* Price Range */}
            <div className="bg-amber-50 rounded-xl p-6 mb-8">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-gray-600 mb-1">Custom Design</p>
                  <p className="text-2xl font-bold text-amber-600">Consult Now for Quote</p>
                </div>
                <div className="text-right">
                  <p className="text-sm text-gray-600 mb-1">Includes</p>
                  <p className="text-sm text-gray-700">Design + Premium Materials + Installation</p>
                </div>
              </div>
            </div>

            {/* Contact CTA */}
            <div className="flex flex-col sm:flex-row gap-4">
              <a
                href="tel:+6282233039914"
                className="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-amber-600 hover:to-orange-600 transition-all duration-300 flex items-center justify-center"
              >
                <Phone className="w-5 h-5 mr-2" />
                Call Now
              </a>
            </div>
          </div>
        </motion.div>

        {/* Key Characteristics */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.2 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-2xl font-bold text-gray-900 mb-6">Key Characteristics</h2>
          <div className="grid md:grid-cols-2 gap-6">
            {style.keyCharacteristics.map((characteristic, index) => (
              <div key={index} className="flex items-start">
                <CheckCircle className="w-5 h-5 text-green-500 mr-3 mt-1" />
                <span className="text-gray-700">{characteristic}</span>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Color Palette */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.3 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-2xl font-bold text-gray-900 mb-6">Color Palette</h2>
          <div className="grid md:grid-cols-5 gap-6">
            {style.colorPalette.map((colorInfo, index) => (
              <div key={index} className="text-center">
                <div
                  className="w-20 h-20 rounded-full mx-auto mb-3 shadow-lg border-4 border-white"
                  style={{ backgroundColor: colorInfo.color }}
                />
                <h3 className="font-semibold text-gray-900 mb-1">{colorInfo.name}</h3>
                <p className="text-sm text-gray-600">{colorInfo.usage}</p>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Materials */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-2xl font-bold text-gray-900 mb-6">Premium Materials</h2>
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {style.materials.map((materialInfo, index) => (
              <div key={index} className="bg-gray-50 rounded-lg p-6">
                <h3 className="font-semibold text-gray-900 mb-2">{materialInfo.material}</h3>
                <p className="text-gray-600 text-sm">{materialInfo.description}</p>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Featured Products */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.5 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-2xl font-bold text-gray-900 mb-6">Signature Cari Prop Shop Pieces</h2>
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {style.featuredProducts.map((product, index) => (
              <div key={index} className="group cursor-pointer">
                <div className="relative overflow-hidden rounded-lg mb-4">
                  <img
                    src={product.image}
                    alt={product.name}
                    className="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300"
                  />
                  <div className="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300" />
                  <div className="absolute top-4 right-4">
                    <div className="bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-semibold text-amber-600">
                      <span>{product.price}</span>
                    </div>
                  </div>
                </div>
                <h3 className="font-semibold text-gray-900 mb-2">{product.name}</h3>
                <p className="text-gray-600 text-sm">{product.description}</p>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Room-by-Room Guide */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.6 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-2xl font-bold text-gray-900 mb-6">Room-by-Room Styling Guide</h2>
          
          {/* Room Tabs */}
          <div className="flex flex-wrap gap-4 mb-8">
            {Object.entries(style.roomGuides).map(([roomKey, room]) => (
              <button
                key={roomKey}
                onClick={() => setActiveRoom(roomKey)}
                className={`px-6 py-3 rounded-lg font-medium transition-all duration-300 ${
                  activeRoom === roomKey
                    ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                }`}
              >
                {room.title}
              </button>
            ))}
          </div>

          {/* Room Content */}
          <div className="grid lg:grid-cols-2 gap-8">
            <div>
              <h3 className="text-xl font-semibold text-gray-900 mb-4">
                {style.roomGuides[activeRoom as keyof typeof style.roomGuides].title} Design
              </h3>
              <p className="text-gray-600 mb-6">
                {style.roomGuides[activeRoom as keyof typeof style.roomGuides].description}
              </p>
              <div className="space-y-3">
                {style.roomGuides[activeRoom as keyof typeof style.roomGuides].tips.map((tip, index) => (
                  <div key={index} className="flex items-start">
                    <Lightbulb className="w-5 h-5 text-amber-500 mr-3 mt-0.5" />
                    <span className="text-gray-700">{tip}</span>
                  </div>
                ))}
              </div>
            </div>
            <div>
              <h4 className="font-semibold text-gray-900 mb-4">Recommended Products</h4>
              <div className="space-y-4">
                {style.roomGuides[activeRoom as keyof typeof style.roomGuides].products.map((productName, index) => (
                  <div key={index} className="bg-gray-50 rounded-lg p-4 flex items-center">
                    <Sofa className="w-6 h-6 text-amber-500 mr-3" />
                    <h5 className="font-medium text-gray-900">{productName}</h5>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </motion.div>

        {/* Contact Section */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.7 }}
          className="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-8 text-center"
        >
          <div className="flex justify-center mb-6">
            <div className="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center">
              <Award className="w-8 h-8 text-white" />
            </div>
          </div>
          <h3 className="text-2xl font-bold text-gray-900 mb-4">
            Ready to Create Your {style.name} Space?
          </h3>
          <p className="text-gray-600 mb-8 max-w-2xl mx-auto">
            Our design experts are ready to help you bring this style to life in your home.
            Start your project today. Consult us now.
          </p>
          <div className="text-center">
            <p className="text-xl font-semibold text-gray-900 mb-2">
              Consult us today
            </p>
            <p className="text-lg text-amber-600 font-medium">
              📞 +6282233039914
            </p>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default StyleDetail;