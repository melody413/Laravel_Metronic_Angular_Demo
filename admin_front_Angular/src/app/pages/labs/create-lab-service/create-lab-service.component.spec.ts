import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateLabServiceComponent } from './create-lab-service.component';

describe('CreateLabServiceComponent', () => {
  let component: CreateLabServiceComponent;
  let fixture: ComponentFixture<CreateLabServiceComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateLabServiceComponent]
    });
    fixture = TestBed.createComponent(CreateLabServiceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
