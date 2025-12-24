<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LoadConfigHelper
{
    static $yheaders = array(
        'tý' => 'Người mang tuổi Tý rất duyên dáng và hấp dẫn người khác phái. Tuy nhiên, họ rất sợ ánh sáng và tiếng động. Người mang tuổi này rất tích cực và năng động nhưng họ cũng thường gặp lắm chuyện vặt vãnh. Người mang tuổi Tý cũng có mặt mạnh vì nếu Chuột xuất hiện có nghĩa là phải có lúa trong bồ.',
        'sửu' => 'Trâu tượng trưng cho sự siêng năng và lòng kiên nhẫn. Năm này có tiến triển vững vàng nhưng chậm và một sức mạnh bền bỉ; người mang tuổi Sửu thường có tính cách thích hợp để trở thành một nhà khoa học. Trâu biểu tượng cho mùa Xuân và nông nghiệp vì gắn liền với cái cày và thích đầm mình trong bùn. Người mang tuổi này thường điềm tĩnh và rất kiên định nhưng rất bướng bỉnh.',
        'dần' => 'Những người mang tuổi hổ thường rất dễ nổi giận, thiếu lập trường nhưng họ có thể rất mềm mỏng và xoay chuyển cá tính cho thích nghi với hoàn cảnh. Hổ là chúa tể rừng xanh, thường sống về đêm và gợi lên những hình ảnh về bóng đen và giông tố. Giờ Dần bắt đầu từ 3 giờ đến 5 giờ khi cọp trở về hang sau khi đi rình mò trong đêm.',
        'mão' => 'Mèo tượng trưng cho những người ăn nói nhẹ nhàng, nhiều tài năng, nhiều tham vọng và sẽ thành công trên con đường học vấn. Họ rất xung khắc với người tuổi Tý. Người tuổi Mão có tinh thần mềm dẻo, tính kiên nhẫn và biết chờ thời cơ trước khi hành động.',
        'thìn' => 'Con rồng trong huyền thoại của người phương Đông là tính Dương của vũ trụ, biểu tượng uy quyền hoàng gia. Theo đó, rồng hiện diện ở khắp mọi nơi, dưới nước, trên mặt đất và không trung. Rồng là biểu tượng của nước và là dấu hiệu thuận lợi cho nông nghiệp. Người tuổi Rồng rất trung thực, năng nổ nhưng rất nóng tính và bướng bỉnh. Họ là biểu tượng của quyền lực, sự giàu có, thịnh vượng và của hoàng tộc.',
        'tỵ' => 'Người tuổi rắn nói ít nhưng rất thông thái. Họ thích hợp với vùng đất ẩm ướt. Rắn tượng trưng cho sự tiến hóa vĩnh cửu của tuổi tác và sự kế vị, sự phân hủy và sự nối tiếp các thế hệ của nhân loại. Người tuổi rắn rất điềm tĩnh, hiền lành, sâu sắc và cảm thông nhưng thỉnh thoảng cũng hay nổi giận. Họ rất kiên quyết và cố chấp.',
        'ngọ' => 'Người tuổi Ngọ thường ăn nói dịu dàng, thoải mái và rộng lượng. Do đó, họ dễ được nhiều người mến chuộng nhưng họ ít khi nghe lời khuyên can. Người tuổi này thường có tính khí rất nóng nảy. Tốc độ chạy của ngựa làm người ta liên tưởng đến mặt trời rọi đến trái đất hàng ngày. Trong thần thoại, mặt trời được cho là liên quan đến những con ngựa đang nổi cơn cuồng nộ. Tuổi này thường được cho là có tính thanh sạch, cao quý và thông thái. Người tuổi này thường được quý trọng do thông minh, mạnh mẽ và đầy thân ái tình người.',
        'mùi' => 'Người mang tuổi Mùi thường rất điềm tĩnh nhưng nhút nhát, rất khiêm tốn nhưng không có lập trường. Họ ăn nói rất vụng về, vì thế họ không thể là người bán hàng giỏi nhưng họ rất cảm thương người hoạn nạn và thường hay giúp đỡ mọi người. Họ thường có lợi thế vì tính tốt bụng và nhút nhát tự nhiên của họ.',
        'thân' => 'Người tuổi Thân thường là một nhân tài có tính cách thất thường. Họ rất tài ba và khéo léo trong các vụ giao dịch tiền bạc. Người tuổi này thường rất vui vẻ, khéo tay, tò mò và nhiều sáng kiến, nhưng họ lại nói quá nhiều nên dễ bị người khác xem thường và khinh ghét. Khuyết điểm của họ nằm trong tính khí thất thường và không nhất quán.',
        'dậu' => 'Năm Dậu tượng trưng cho một giai đoạn hoạt động lao động cần cù siêng năng vì gà phải bận rộn từ sáng đến tối. Cái mào của nó là một dấu hiệu của sự cực kỳ thông minh và một trí tuệ bác học. Người sinh vào năm Dậu được xem là người có tư duy sâu sắc. Đồng thời, gà được coi là sự bảo vệ chống lại lửa. Người sinh vào năm Dậu thường kiếm sống nhờ kinh doanh nhỏ, làm ăn cần cù như một chú gà bới đất tìm sâu.',
        'tuất' => 'Năm Tuất cho biết một tương lai thịnh vượng. Trên khắp thế giới, chó được dùng để giữ nhà chống lại những kẻ xâm nhập. Những cặp chó đá thường được đặt hai bên cổng làng để bảo vệ. Năm Tuất được tin là năm rất an toàn.',
        'hợi' => 'Lợn tượng trưng cho sự giàu có vì loài lợn rừng thường làm hang trong những khu rừng. Người tuổi Hợi rất hào hiệp, galăng, tốt bụng và dũng cảm nhưng thường rất bướng bỉnh, nóng tính nhưng siêng năng và chịu lắng nghe.',
    );



    static $yheaderscanchi = array(
        'Bính Dần' => 'Trong quan niệm phương Đông, tuổi Dần tượng trưng cho những người mạnh mẽ, quyết đoán và dũng cảm. Vì thế, năm Bính Dần thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Đinh Mão' => 'Trong quan niệm phương Đông, tuổi Mão tượng trưng cho những người khéo léo, hiền hòa và tinh tế. Vì thế, năm Đinh Mão thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Mậu Thìn' => 'Trong quan niệm phương Đông, tuổi Thìn tượng trưng cho những người quyết đoán, mạnh mẽ và có chí tiến thủ. Vì thế, năm Mậu Thìn thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Kỷ Tỵ' => 'Trong quan niệm phương Đông, tuổi Tỵ tượng trưng cho những người khôn ngoan, bí ẩn và có trực giác nhạy bén. Vì thế, năm Kỷ Tỵ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Canh Ngọ' => 'Trong quan niệm phương Đông, tuổi Ngọ tượng trưng cho những người nhiệt huyết, phóng khoáng và yêu tự do. Vì thế, năm Canh Ngọ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Tân Mùi' => 'Trong quan niệm phương Đông, tuổi Mùi tượng trưng cho những người hiền lành, nhân hậu và sống giàu tình cảm. Vì thế, năm Tân Mùi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Nhâm Thân' => 'Trong quan niệm phương Đông, tuổi Thân tượng trưng cho những người lanh lợi, thông minh và giỏi giao tiếp. Vì thế, năm Nhâm Thân thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Quý Dậu' => 'Trong quan niệm phương Đông, tuổi Dậu tượng trưng cho những người chăm chỉ, kỷ luật và đáng tin cậy. Vì thế, năm Quý Dậu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Giáp Tuất' => 'Trong quan niệm phương Đông, tuổi Tuất tượng trưng cho những người trung thành, chính trực và giàu tình nghĩa. Vì thế, năm Giáp Tuất thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Ất Hợi' => 'Trong quan niệm phương Đông, tuổi Hợi tượng trưng cho những người hiền lành, chân thành và sống chan hòa. Vì thế, năm Ất Hợi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Bính Tý' => 'Trong quan niệm phương Đông, tuổi Tý tượng trưng cho những người thông minh, nhanh nhẹn và linh hoạt. Vì thế, năm Bính Tý thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Đinh Sửu' => 'Trong quan niệm phương Đông, tuổi Sửu tượng trưng cho những người cần cù, bền bỉ và đáng tin cậy. Vì thế, năm Đinh Sửu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Mậu Dần' => 'Trong quan niệm phương Đông, tuổi Dần tượng trưng cho những người mạnh mẽ, quyết đoán và dũng cảm. Vì thế, năm Mậu Dần thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Kỷ Mão' => 'Trong quan niệm phương Đông, tuổi Mão tượng trưng cho những người khéo léo, hiền hòa và tinh tế. Vì thế, năm Kỷ Mão thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Canh Thìn' => 'Trong quan niệm phương Đông, tuổi Thìn tượng trưng cho những người quyết đoán, mạnh mẽ và có chí tiến thủ. Vì thế, năm Canh Thìn thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Tân Tỵ' => 'Trong quan niệm phương Đông, tuổi Tỵ tượng trưng cho những người khôn ngoan, bí ẩn và có trực giác nhạy bén. Vì thế, năm Tân Tỵ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng',
        'Nhâm Ngọ' => 'Trong quan niệm phương Đông, tuổi Ngọ tượng trưng cho những người nhiệt huyết, phóng khoáng và yêu tự do. Vì thế, năm Nhâm Ngọ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Quý Mùi' => 'Trong quan niệm phương Đông, tuổi Mùi tượng trưng cho những người hiền lành, nhân hậu và sống giàu tình cảm. Vì thế, năm Quý Mùi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Giáp Thân' => 'Trong quan niệm phương Đông, tuổi Thân tượng trưng cho những người lanh lợi, thông minh và giỏi giao tiếp. Vì thế, năm Giáp Thân thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Ất Dậu' => 'Trong quan niệm phương Đông, tuổi Dậu tượng trưng cho những người chăm chỉ, kỷ luật và đáng tin cậy. Vì thế, năm Ất Dậu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Bính Tuất' => 'Trong quan niệm phương Đông, tuổi Tuất tượng trưng cho những người trung thành, chính trực và giàu tình nghĩa. Vì thế, năm Bính Tuất thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Đinh Hợi' => 'Trong quan niệm phương Đông, tuổi Hợi tượng trưng cho những người hiền lành, chân thành và sống chan hòa. Vì thế, năm Đinh Hợi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Mậu Tý' => ' Trong quan niệm phương Đông, tuổi Tý tượng trưng cho những người thông minh, nhanh nhẹn và linh hoạt. Vì thế, năm Mậu Tý thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Kỷ Sửu' => 'Trong quan niệm phương Đông, tuổi Sửu tượng trưng cho những người cần cù, bền bỉ và đáng tin cậy. Vì thế, năm Kỷ Sửu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Canh Dần' => 'Trong quan niệm phương Đông, tuổi Dần tượng trưng cho những người mạnh mẽ, quyết đoán và dũng cảm. Vì thế, năm Canh Dần thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Tân Mão' => 'Trong quan niệm phương Đông, tuổi Mão tượng trưng cho những người khéo léo, hiền hòa và tinh tế. Vì thế, năm Tân Mão thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Nhâm Thìn' => 'Trong quan niệm phương Đông, tuổi Thìn tượng trưng cho những người quyết đoán, mạnh mẽ và có chí tiến thủ. Vì thế, năm Nhâm Thìn thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Quý Tỵ' => 'Trong quan niệm phương Đông, tuổi Tỵ tượng trưng cho những người khôn ngoan, bí ẩn và có trực giác nhạy bén. Vì thế, năm Quý Tỵ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Giáp Ngọ' => 'Trong quan niệm phương Đông, tuổi Ngọ tượng trưng cho những người nhiệt huyết, phóng khoáng và yêu tự do. Vì thế, năm Giáp Ngọ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Ất Mùi' => 'Trong quan niệm phương Đông, tuổi Mùi tượng trưng cho những người hiền lành, nhân hậu và sống giàu tình cảm. Vì thế, năm Ất Mùi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Bính Thân' => 'Trong quan niệm phương Đông, tuổi Thân tượng trưng cho những người lanh lợi, thông minh và giỏi giao tiếp. Vì thế, năm Bính Thân thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Đinh Dậu' => 'Trong quan niệm phương Đông, tuổi Dậu tượng trưng cho những người chăm chỉ, kỷ luật và đáng tin cậy. Vì thế, năm Đinh Dậu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Mậu Tuất' => 'Trong quan niệm phương Đông, tuổi Tuất tượng trưng cho những người trung thành, chính trực và giàu tình nghĩa. Vì thế, năm Mậu Tuất thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Kỷ Hợi' => 'Trong quan niệm phương Đông, tuổi Hợi tượng trưng cho những người hiền lành, chân thành và sống chan hòa. Vì thế, năm Kỷ Hợi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Canh Tý' => 'Trong quan niệm phương Đông, tuổi Tý tượng trưng cho những người thông minh, nhanh nhẹn và linh hoạt. Vì thế, năm Canh Tý thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Tân Sửu' => 'Trong quan niệm phương Đông, tuổi Sửu tượng trưng cho những người cần cù, bền bỉ và đáng tin cậy. Vì thế, năm Tân Sửu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Nhâm Dần' => 'Trong quan niệm phương Đông, tuổi Dần tượng trưng cho những người mạnh mẽ, quyết đoán và dũng cảm. Vì thế, năm Nhâm Dần thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Quý Mão' => 'Trong quan niệm phương Đông, tuổi Mão tượng trưng cho những người khéo léo, hiền hòa và tinh tế. Vì thế, năm Quý Mão thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Giáp Thìn' => 'Trong quan niệm phương Đông, tuổi Thìn tượng trưng cho những người quyết đoán, mạnh mẽ và có chí tiến thủ. Vì thế, năm Giáp Thìn thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Ất Tỵ' => 'Trong quan niệm phương Đông, tuổi Tỵ tượng trưng cho những người khôn ngoan, bí ẩn và có trực giác nhạy bén. Vì thế, năm Ất Tỵ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Bính Ngọ' => 'Trong quan niệm phương Đông, tuổi Ngọ tượng trưng cho những người nhiệt huyết, phóng khoáng và yêu tự do. Vì thế, năm Bính Ngọ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Đinh Mùi' => 'Trong quan niệm phương Đông, tuổi Mùi tượng trưng cho những người hiền lành, nhân hậu và sống giàu tình cảm. Vì thế, năm Đinh Mùi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Mậu Thân' => 'Trong quan niệm phương Đông, tuổi Thân tượng trưng cho những người lanh lợi, thông minh và giỏi giao tiếp. Vì thế, năm Mậu Thân thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Kỷ Dậu' => 'Trong quan niệm phương Đông, tuổi Dậu tượng trưng cho những người chăm chỉ, kỷ luật và đáng tin cậy. Vì thế, năm Kỷ Dậu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Canh Tuất' => 'Trong quan niệm phương Đông, tuổi Tuất tượng trưng cho những người trung thành, chính trực và giàu tình nghĩa. Vì thế, năm Canh Tuất thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Tân Hợi' => 'Trong quan niệm phương Đông, tuổi Hợi tượng trưng cho những người hiền lành, chân thành và sống chan hòa. Vì thế, năm Tân Hợi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Nhâm Tý' => 'Trong quan niệm phương Đông, tuổi Tý tượng trưng cho những người thông minh, nhanh nhẹn và linh hoạt. Vì thế, năm Nhâm Tý thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Quý Sửu' => 'Trong quan niệm phương Đông, tuổi Sửu tượng trưng cho những người cần cù, bền bỉ và đáng tin cậy. Vì thế, năm Quý Sửu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Giáp Dần' => 'Trong quan niệm phương Đông, tuổi Dần tượng trưng cho những người mạnh mẽ, quyết đoán và dũng cảm. Vì thế, năm Giáp Dần thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Ất Mão' => 'Trong quan niệm phương Đông, tuổi Mão tượng trưng cho những người khéo léo, hiền hòa và tinh tế. Vì thế, năm Ất Mão thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Bính Thìn' => 'Trong quan niệm phương Đông, tuổi Thìn tượng trưng cho những người quyết đoán, mạnh mẽ và có chí tiến thủ. Vì thế, năm Bính Thìn thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Đinh Tỵ' => 'Trong quan niệm phương Đông, tuổi Tỵ tượng trưng cho những người khôn ngoan, bí ẩn và có trực giác nhạy bén. Vì thế, năm Đinh Tỵ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Mậu Ngọ' => 'Trong quan niệm phương Đông, tuổi Ngọ tượng trưng cho những người nhiệt huyết, phóng khoáng và yêu tự do. Vì thế, năm Mậu Ngọ thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Kỷ Mùi' => 'Trong quan niệm phương Đông, tuổi Mùi tượng trưng cho những người hiền lành, nhân hậu và sống giàu tình cảm. Vì thế, năm Kỷ Mùi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Canh Thân' => 'Trong quan niệm phương Đông, tuổi Thân tượng trưng cho những người lanh lợi, thông minh và giỏi giao tiếp. Vì thế, năm Canh Thân thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Tân Dậu' => 'Trong quan niệm phương Đông, tuổi Dậu tượng trưng cho những người chăm chỉ, kỷ luật và đáng tin cậy. Vì thế, năm Tân Dậu thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Nhâm Tuất' => 'Trong quan niệm phương Đông, tuổi Tuất tượng trưng cho những người trung thành, chính trực và giàu tình nghĩa. Vì thế, năm Nhâm Tuất thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',
        'Quý Hợi' => 'Trong quan niệm phương Đông, tuổi Hợi tượng trưng cho những người hiền lành, chân thành và sống chan hòa. Vì thế, năm Quý Hợi thường được xem là gắn liền với các giá trị và ý nghĩa phong thủy đặc trưng.',

    );
    public static function generateMonthDescription($thang, $nam, $can_chi_nam, $is_leap = false)
    {
        $description = "";
        // Sử dụng $is_leap để lấy đúng ngày dương của tháng (bao gồm cả tháng nhuận)
        $leap_flag = $is_leap ? 1 : 0;

        $solarDateForFirstDay = LunarHelper::convertLunar2Solar(1, $thang, $nam, $leap_flag);
        list($dd, $mm, $yy) = $solarDateForFirstDay;
        list($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $isFullMonth) = LunarHelper::convertSolar2Lunar($dd, $mm, $yy);
        $daysInMonth = ($isFullMonth == 'Đủ') ? 30 : 29;

        $startDateSolar = Carbon::createFromDate($yy, $mm, $dd)->format('d/m/Y');

        $solarDateForLastDay = LunarHelper::convertLunar2Solar($daysInMonth, $thang, $nam, $leap_flag);
        $text_nhuan = $leap_flag ? '(Nhuận)' : '';

        list($end_dd, $end_mm, $end_yy) = $solarDateForLastDay;
        //  $startDateSolar = Carbon::createFromDate($end_yy, $end_mm, $end_dd)->format('d/m/Y');
        $endDateSolar = Carbon::createFromDate($end_yy, $end_mm, $end_dd)->format('d/m/Y');
        switch ($thang) {
            case 1:
                $description = "
                <p>Lịch âm tháng 1 {$text_nhuan} năm {$nam} (tức tháng Giêng năm {$can_chi_nam}) bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Đây là tháng mở đầu cho một năm mới, đồng thời là thời điểm diễn ra nhiều ngày lễ quan trọng như Tết Nguyên Đán, Rằm tháng Giêng (Tết Nguyên Tiêu) cùng những phong tục văn hóa đặc sắc của người Việt.</p>
               <p>Khi tra cứu lịch vạn niên tháng 1/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                <ul>
                    <li> Bảng đối chiếu ngày Âm lịch – Dương lịch chi tiết.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 1 {$text_nhuan} năm {$nam}, bạn dễ dàng nắm bắt các ngày quan trọng, vừa phục vụ sinh hoạt thường ngày, vừa hỗ trợ việc chọn ngày đẹp cho những dự định đầu năm.</p>
               ";
                break;
            case 2:
                $description = "
                <p>Lịch âm tháng 2 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Đây là tháng tiếp nối sau Tết Nguyên Đán, thường gắn liền với nhiều hoạt động lễ hội, cầu may và du xuân của người Việt.</p>
                <p>Khi tra cứu lịch vạn niên tháng 2/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                 <ul>
                    <li> Bảng đối chiếu ngày Âm lịch – Dương lịch chi tiết.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 2 {$text_nhuan} năm {$nam}, bạn sẽ dễ dàng theo dõi ngày tháng, lựa chọn thời điểm thuận lợi cho công việc, sự kiện và những dự định đầu năm.</p>
                ";
                break;
            case 3:
                $description = "
                <p>Lịch âm tháng 3 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Tháng 3 âm lịch thường gắn liền với nhiều lễ hội truyền thống và phong tục tưởng nhớ tổ tiên, trong đó có ngày Giỗ Tổ Hùng Vương (mùng 10/3 âm lịch) – một trong những ngày lễ trọng đại của dân tộc Việt Nam.</p>
                <p>Khi tra cứu lịch vạn niên tháng 3/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 3 {$text_nhuan} năm {$nam}, bạn dễ dàng nắm bắt ngày tháng và lựa chọn thời điểm thích hợp cho cả sinh hoạt thường nhật lẫn những sự kiện quan trọng.</p>
                ";
                break;
            case 4:
                $description = "
                <p>Lịch âm tháng 4 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Tháng 4 âm lịch thường là thời điểm chuyển giao mùa, gắn liền với nhiều hoạt động sản xuất nông nghiệp, đồng thời cũng có các dịp lễ hội và sinh hoạt văn hóa dân gian của người Việt.</p>
                <p>Khi tra cứu lịch vạn niên tháng 4/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                 <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 4 {$text_nhuan} năm {$nam}, bạn dễ dàng theo dõi ngày tháng, đồng thời lựa chọn được thời điểm đẹp, thuận lợi cho cuộc sống và công việc.</p>
                ";
                break;
            case 5:
                $description = "
                <p>Lịch âm tháng 5 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Đây là tháng giữa năm, gắn liền với ngày Tết Đoan Ngọ (mùng 5/5 âm lịch) – dịp lễ truyền thống quan trọng trong văn hóa Việt, mang ý nghĩa trừ tà, diệt sâu bọ và cầu mong sức khỏe, bình an cho gia đình.</p>
                <p>Khi tra cứu lịch vạn niên tháng 5/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                  <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 5 {$text_nhuan} năm {$nam}, bạn sẽ dễ dàng nắm bắt ngày tháng quan trọng, đồng thời chọn được thời điểm cát lợi để triển khai những kế hoạch quan trọng trong cuộc sống.</p>
                ";
                break;
            case 6:
                $description = "
                <p>Lịch âm tháng 6 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Đây là giai đoạn giữa năm, thời tiết chuyển mùa, nhiều gia đình tổ chức nghi lễ cầu an, báo hiếu tổ tiên và tham gia các lễ hội mùa hè đặc sắc.</p>
                <p>Khi tra cứu lịch vạn niên tháng 6/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 6 {$text_nhuan} năm {$nam}, bạn sẽ dễ dàng tra cứu và lựa chọn thời điểm thuận lợi, giúp mọi kế hoạch trong tháng diễn ra suôn sẻ và may mắn.</p>
                ";
                break;
            case 7:
                $description = "
                <p>Lịch âm tháng 7 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Tháng 7 âm lịch thường gắn liền với ý nghĩa tâm linh sâu sắc, đặc biệt là Rằm tháng 7 – Lễ Vu Lan báo hiếu và lễ Xá tội vong nhân, được xem là dịp để tưởng nhớ tổ tiên, tri ân cha mẹ và cầu bình an cho gia đình.</p>
                <p>Khi tra cứu lịch vạn niên tháng 7/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 7 {$text_nhuan} năm {$nam}, bạn dễ dàng nắm bắt ngày tháng quan trọng, đồng thời lựa chọn thời điểm cát lợi để tiến hành những dự định quan trọng cho gia đình và công việc.</p>
                ";
                break;
            case 8:
                $description = "
                <p>Lịch âm tháng 8 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Tháng 8 âm lịch nổi bật với Tết Trung Thu (Rằm tháng 8) – ngày tết đoàn viên, là dịp để gia đình sum họp, trẻ em vui hội trăng rằm và nhiều lễ hội dân gian đặc sắc được tổ chức trên khắp cả nước.</p>
                <p>Khi tra cứu lịch vạn niên tháng 8/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 8 {$text_nhuan} năm {$nam}, bạn sẽ dễ dàng tra cứu ngày tháng, đồng thời lựa chọn thời điểm đẹp để tổ chức các hoạt động, sự kiện ý nghĩa cho gia đình và cá nhân.</p>
                ";
                break;
            case 9:
                $description = "
                <p>Lịch âm tháng 9 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Tháng 9 âm lịch thường gắn liền với Tết Trùng Cửu (mùng 9/9 âm lịch) – ngày lễ truyền thống cầu trường thọ, may mắn và bình an cho gia đình.</p>
                <p>Khi tra cứu lịch vạn niên tháng 9/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 9 {$text_nhuan} năm {$nam}, bạn có thể dễ dàng theo dõi ngày tháng và chọn được những thời điểm cát lợi để triển khai công việc, kế hoạch và các sự kiện quan trọng trong tháng.</p>
                ";
                break;
            case 10:
                $description = "
                <p>Lịch âm tháng 10 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Tháng 10 âm lịch thường gắn với thời điểm cuối thu, đầu đông, là lúc người dân chuẩn bị mùa màng và tiến hành nhiều nghi lễ truyền thống quan trọng trong năm.</p>
                <p>Khi tra cứu lịch vạn niên tháng 10/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 10 {$text_nhuan} năm {$nam}, bạn có thể dễ dàng nắm bắt ngày tháng quan trọng và lựa chọn thời điểm đẹp để tiến hành những việc lớn nhỏ trong đời sống gia đình cũng như công việc.</p>
                ";
                break;
            case 11:
                $description = "
                <p>Lịch âm tháng 11 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Tháng 11 âm lịch là giai đoạn cuối năm, khi các gia đình bận rộn chuẩn bị cho Tết Nguyên Đán, đồng thời tiến hành nhiều nghi lễ quan trọng để tổng kết một năm cũ và cầu mong may mắn cho năm mới.</p>
                <p>Khi tra cứu lịch vạn niên tháng 11/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li> Thông tin ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                <p>Với lịch âm tháng 11 {$text_nhuan} năm {$nam}, bạn dễ dàng theo dõi ngày tháng và chọn được thời điểm thích hợp để chuẩn bị cho một cái Tết trọn vẹn, an lành và may mắn.</p>
                ";
                break;
            case 12:
                $description = "
                <p>Lịch âm tháng 12 {$text_nhuan} năm {$nam} bắt đầu từ ngày {$startDateSolar} và kết thúc vào ngày {$endDateSolar} theo Dương lịch. Tháng Chạp là tháng cuối cùng của năm âm lịch, gắn liền với không khí tất bật chuẩn bị đón Tết Nguyên Đán. Đây cũng là thời điểm diễn ra nhiều nghi lễ quan trọng như cúng ông Công ông Táo (23 tháng Chạp), tất niên và chuẩn bị mâm cỗ Tết.</p>
                <p>Khi tra cứu lịch vạn niên tháng 12/{$nam} trên Phong Lịch, bạn sẽ có:</p>
                 <ul>
                    <li>Lịch đối chiếu chi tiết giữa Âm lịch – Dương lịch cho từng ngày.</li>
                    <li>Thông tin về ngày hoàng đạo, hắc đạo, tiết khí trong tháng.</li>
                    <li>Gợi ý xem ngày tốt, giờ tốt để chọn thời điểm phù hợp cho cưới hỏi, xuất hành, khai trương.</li>
                    <li>Danh sách các ngày lễ tết quan trọng trong tháng.</li>
                </ul>
                Với lịch âm tháng 12 {$text_nhuan} năm {$nam}, bạn không chỉ dễ dàng quản lý ngày tháng cuối năm mà còn có thể chọn được những ngày đẹp để khép lại một năm cũ và đón chào năm mới trọn vẹn, may mắn.
                ";
                
                break;
            default:
                $description = "Mô tả mặc định cho tháng {$thang} năm {$nam}.";
                break;
        }
        return $description;
    }

    static $ledl = array(
        array(
            'dd' => 1,
            'mm' => 1,
            'name' => '🥳Tết Dương lịch'
        ),
        array(
            'dd' => 14,
            'mm' => 2,
            'name' => 'Lễ tình nhân (Valentine)'
        ),
        array(
            'dd' => 3,
            'mm' => 2,
            'name' => 'Ngày thành lập Đảng Cộng sản Việt Nam'
        ),
        array(
            'dd' => 27,
            'mm' => 2,
            'name' => 'Ngày Thầy thuốc Việt Nam'
        ),
        array(
            'dd' => 8,
            'mm' => 3,
            'name' => 'Ngày Quốc tế Phụ nữ'
        ),
        array(
            'dd' => 10,
            'mm' => 3,
            'name' => 'Ngày thành lập Hội Liên hiệp Phụ nữ Việt Nam'
        ),
        array(
            'dd' => 24,
            'mm' => 3,
            'name' => 'Ngày Thế giới chống lao'
        ),
        array(
            'dd' => 26,
            'mm' => 3,
            'name' => 'Ngày thành lập Đoàn TNCS Hồ Chí Minh'
        ),
        array(
            'dd' => 1,
            'mm' => 4,
            'name' => 'Ngày Cá tháng Tư'
        ),
        array(
            'dd' => 30,
            'mm' => 4,
            'name' => 'Ngày giải phóng miền Nam'
        ),
        array(
            'dd' => 1,
            'mm' => 5,
            'name' => 'Ngày Quốc tế Lao động'
        ),
        array(
            'dd' => 7,
            'mm' => 5,
            'name' => 'Ngày chiến thắng Điện Biên Phủ'
        ),
        // array(
        //     'dd' => 8,
        //     'mm' => 5,
        //     'name' => 'Ngày chiến thắng phát xít'
        // ),
        array(
            'dd' => 19,
            'mm' => 5,
            'name' => 'Ngày sinh chủ tịch Hồ Chí Minh'
        ),
        array(
            'dd' => 1,
            'mm' => 6,
            'name' => 'Ngày Quốc tế Thiếu nhi'
        ),
        array(
            'dd' => 17,
            'mm' => 6,
            'name' => 'Ngày của Cha'
        ),
        array(
            'dd' => 21,
            'mm' => 6,
            'name' => 'Ngày Báo chí cách mạng Việt Nam'
        ),
        array(
            'dd' => 28,
            'mm' => 6,
            'name' => 'Ngày gia đình Việt Nam'
        ),
        array(
            'dd' => 11,
            'mm' => 7,
            'name' => 'Ngày Dân số thế giới' //
        ),
        array(
            'dd' => 27,
            'mm' => 7,
            'name' => 'Ngày Thương binh Liệt sĩ'
        ),
        array(
            'dd' => 28,
            'mm' => 7,
            'name' => 'Ngày thành lập Công đoàn Việt Nam'
        ),
        array(
            'dd' => 15,
            'mm' => 8,
            'name' => 'Ngày Độc lập'
        ),
        array(
            'dd' => 19,
            'mm' => 8,
            'name' => 'Ngày Tổng khởi nghĩa'
        ),
        array(
            'dd' => 2,
            'mm' => 9,
            'name' => 'Ngày Quốc khánh'
        ),
        array(
            'dd' => 10,
            'mm' => 9,
            'name' => 'Ngày thành lập Mặt trận Tổ quốc Việt Nam'
        ),
        array(
            'dd' => 15,
            'mm' => 9,
            'name' => 'Ngày Trẻ em Việt Nam'
        ),
        array(
            'dd' => 1,
            'mm' => 10,
            'name' => 'Ngày Quốc tế Người cao tuổi'
        ),
        array(
            'dd' => 10,
            'mm' => 10,
            'name' => 'Ngày Giải phóng Thủ đô'
        ),
        array(
            'dd' => 13,
            'mm' => 10,
            'name' => 'Ngày Doanh nhân Việt Nam'
        ),
        array(
            'dd' => 20,
            'mm' => 10,
            'name' => 'Ngày Phụ nữ Việt Nam'
        ),
        array(
            'dd' => 31,
            'mm' => 10,
            'name' => 'Ngày Hallowen'
        ),
        array(
            'dd' => 9,
            'mm' => 11,
            'name' => 'Ngày Pháp luật Việt Nam'
        ),
          array(
            'dd' => 19,
            'mm' => 11,
            'name' => 'Quốc tế Nam giới'
        ),
        array(
            'dd' => 20,
            'mm' => 11,
            'name' => 'Ngày Nhà giáo Việt Nam'
        ),
        array(
            'dd' => 23,
            'mm' => 11,
            'name' => 'Ngày thành lập Hội Chữ thập đỏ Việt Nam'
        ),
        array(
            'dd' => 1,
            'mm' => 12,
            'name' => 'Ngày Thế giới phòng chống AIDS'
        ),
        array(
            'dd' => 19,
            'mm' => 12,
            'name' => 'Ngày toàn quốc kháng chiến'
        ),
        array(
            'dd' => 24,
            'mm' => 12,
            'name' => '🎅🏻 Đêm Giáng sinh'
        ),
        array(
            'dd' => 25,
            'mm' => 12,
            'name' => '🎁 Lễ Giáng sinh'
        ),
        array(
            'dd' => 22,
            'mm' => 12,
            'name' => 'Ngày thành lập Quân đội Nhân dân Việt Nam'
        ),
    );

    static $leal = array(
        array(
            'dd' => 1,
            'mm' => 1,
            'name' => '🧧 Tết Nguyên Đán',
        ),
        array(
            'dd' => 2,
            'mm' => 1,
            'name' => 'Mùng 2 Tết (Khai ấn)',
        ),
        array(
            'dd' => 3,
            'mm' => 1,
            'name' => 'Mùng 3 Tết (Khai hạ)',
        ),
        array(
            'dd' => 15,
            'mm' => 1,
            'name' => 'Tết Nguyên Tiêu (Lễ Thượng Nguyên)',
        ),
        array(
            'dd' => 3,
            'mm' => 3,
            'name' => 'Tết Hàn Thực',
        ),
        array(
            'dd' => 10,
            'mm' => 3,
            'name' => 'Giỗ Tổ Hùng Vương',
        ),
        array(
            'dd' => 15,
            'mm' => 4,
            'name' => 'Lễ Phật Đản',
        ),
        array(
            'dd' => 5,
            'mm' => 5,
            'name' => 'Tết Đoan Ngọ',
        ),
        array(
            'dd' => 1,
            'mm' => 7,
            'name' => 'Lễ Đại Thệ',
        ),
        array(
            'dd' => 15,
            'mm' => 7,
            'name' => 'Lễ Vu Lan',
        ),
        array(
            'dd' => 30,
            'mm' => 7,
            'name' => 'Ngày địa tạng',
        ),
        array(
            'dd' => 1,
            'mm' => 8,
            'name' => 'Lễ Thánh Mẫu',
        ),
        array(
            'dd' => 15,
            'mm' => 8,
            'name' => 'Tết Trung Thu',
        ),
        array(
            'dd' => 9,
            'mm' => 9,
            'name' => 'Tết Trùng Cửu',
        ),
        array(
            'dd' => 10,
            'mm' => 10,
            'name' => 'Tết Thường Tân',
        ),
        array(
            'dd' => 15,
            'mm' => 10,
            'name' => 'Tết Hạ Nguyên',
        ),
        array(

            'dd' => 23,
            'mm' => 12,
            'name' => 'Tiễn Táo Quân về trời',
        ),
    );

    static $sukien = array(
        1 => array(
            '06/01/1946 : Tổng tuyển cử bầu Quốc hội đầu tiên của nước Việt Nam Dân chủ Cộng hòa',
            '07/01/1979 : Chiến thắng biên giới Tây Nam chống quân xâm lược',
            '09/01/1950 : Ngày Truyền thống Học sinh, Sinh viên Việt nam.',
            '13/01/1941 : Khởi nghĩa Đô Lương',
            '11/01/2007 : Việt Nam gia nhập WTO',
            '27/01/1973 : Ký hiệp định Paris',
        ),
        2 => array(
            '03/02/1930 : Thành lập Đảng cộng sản Việt Nam',
            '08/02/1941 : Lãnh tụ Hồ Chí Minh trở về nước trực tiếp lãnh đạo cách mạng Việt Nam',
        ),
        3 => array(
            '11/03/1945 : Khởi nghĩa Ba Tơ',
            '18/03/1979 : Chiến thắng quân Trung Quốc xâm lược trên biên giới phía Bắc',
            '26/03/1931 : Ngày thành lập Đoàn TNCS Hồ Chí Minh',
        ),
        4 => array(
            '25/4/1976: Ngày tổng tuyển cử bầu quốc hội chung của cả nước',
            '30/4/1975: Giải phóng Miền Nam, thống nhất đất nước',
        ),
        5 => array(
            '07/05/1954: Ngày Chiến thắng Điện Biên Phủ',
            '15/05/1941: Thành lập Đội TNTP Hồ Chí Minh',
            '19/05/1890: Ngày sinh Chủ tịch Hồ Chí Minh',
            '19/05/1941: Thành lập Mặt trận Việt Minh',
        ),
        6 => array(
            '05/06/1911: Nguyễn Tất Thành rời cảng Nhà Rồng ra đi tìm đường cứu nước',
        ),
        7 => array(
            '02/07/1976: Nước ta đổi quốc hiệu từ Việt Nam Dân chủ cộng hòa thành Cộng hòa XHCN Việt Nam',
            '17/07/1966: Hồ chủ tịch ra lời kêu gọi “Không có gì quý hơn độc lập, tự do”',
            '28/07: Thành lập công đoàn Việt Nam(1929)/Ngày Việt Nam gia nhập Asean(1995)',
        ),
        8 => array(
            '01/08/1930: Ngày truyền thống công tác tư tưởng văn hoá của Đảng',
            '19/08/1945: Cách mạng tháng 8 (Ngày Công an nhân dân)',
            '20/08/1888: Ngày sinh chủ tịch Tôn Đức Thắng',
        ),
        9 => array(
            '02/09: Quốc khánh (1945)/ Ngày Chủ tịch Hồ Chí Minh qua đời (1969)',
            '10/09/1955: Thành lập Mặt trận Tổ quốc Việt Nam',
            '12/09/1930: Xô Viết Nghệ Tĩnh',
            '20/09/1977: Việt Nam trở thành thành viên Liên hiệp quốc',
            '23/09/1945: Nam Bộ kháng chiến',
            '27/09/1940: Khởi nghĩa Bắc Sơn',
        ),
        10 => array(
            '10/10/1954: Giải phóng Thủ đô',
            '14/10/1930: Ngày hội Nông dân Việt Nam',
            '15/10/1956: Ngày truyền thống Hội thanh niên Việt Nam',
            '20/10/1930: Thành lập Hội liên hiệp phụ nữ Việt Nam',
        ),
        11 => array(
            '23/11/1940: Khởi nghĩa Nam Kỳ',
            '23/11/1946: Thành lập Hội Chữ thập đỏ Việt Nam',
        ),
        12 => array(
            '19/12/1946: Toàn quốc kháng chiến',
            '22/12/1944: Thành lập Quân đội nhân dân Việt Nam',
        ),
    );
}
